<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\Processo;
use app\models\Magistrado;
use app\models\Orgao;
use app\models\Partes;
use app\models\Testemunha;

class ProcessoController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'criar'  => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista um resumo de todos os processos
     * Rota: GET /processo
     */
    public function actionIndex()
    {
        $data = [];
        $processos = Processo::fetchAll();
        foreach ($processos as $p) $data[] = $p->getResumo();

        return $this->asJson($data);
    }

    /**
     * Ler todos os dados de um processo
     * Rota: GET /processo/info?id={processo_id}
     */
    public function actionInfo($id)
    {
        $processo = Processo::findOneById($id);
        return $this->asJson($processo->asArray());
    }

    /**
     * Cria um processo
     * rota: POST /processo/criar
     */
    public function actionCriar()
    {
        //Pega a requisição
        $request = Yii::$app->request;

        // Define variaveis fora do try-catch
        $processo = null;
        $transaction = null;

        try {
            // Ler o corpo da requisição em JSON com os dados de entrada
            $data = json_decode($request->getRawBody(), true);

            //Busca os registros que serão necessarias para os relacionamentos
            $juiz = Magistrado::findOneById(isset($data['juiz']) ? $data['juiz'] : 0);
            $orgao = Orgao::findOneById(isset($data['orgao']) ? $data['orgao'] : 0);
            $vara = $juiz->getVara();

            //Cria uma instância de Processo
            $processo = new Processo($vara);

            //Define o juiz e o orgão do processo
            $processo->setJuiz($juiz);
            $processo->setOrgao($orgao);

            //Define outros campos do processo
            $processo->setAssunto(isset($data['assunto']) ? $data['assunto'] : '');
            $processo->setFatos(isset($data['fatos']) ? $data['fatos'] : '');
            $processo->setPedidos(isset($data['pedidos']) ? $data['pedidos'] : '');
            $processo->setValor(isset($data['valor']) ? $data['valor'] : '');

            //Parseia entrada para ler ou criar os registros das partes e testemunhas
            $partes = Partes::parsePartes($data['partes']);
            $testemunhas = Testemunha::parseTestemunhas($data['testemulhas']);

            //Inicia uma trasação com o banco
            $transaction = Processo::getDb()->beginTransaction();

            // Se o autor ou o reu forem novos registros, guarda no banco
            if($partes['autor']->getIsNewRecord()) $partes['autor']->save();
            if($partes['reu']->getIsNewRecord()) $partes['reu']->save();

            //Instância um objeto Partes, inicializa e salva
            $partesObj = new Partes();
            $partesObj->setAutor($partes['autor'])
                      ->setReu($partes['reu'])
                      ->setAutorAdvogado($partes['autor_adv'])
                      ->setReuAdvogado($partes['reu_adv'])
                      ->save();

            //Define as partes do processo e salva o processo
            $processo->setPartes($partesObj)
                     ->save();

            //Cria instâncias de Testemunha, relaciona com o processo e as salva
            foreach ($testemunhas as $k => $t) {
                $testemunhas[$k] = Testemunha::criarTestemunha($t, $processo);
                $testemunhas[$k]->save();
            }

            //Salva a vara com a nova sequencia
            $vara->save();

            //Se tudo correu bem, confirma as alterações no banco
            $transaction->commit();
        } catch(\Throwable $e) {
            //Se houve algum erro, faz rollback no banco
            if($transaction != null) $transaction->rollBack();
            throw $e;
        }

        //Retorna o novo processo como JSON
        return $this->asJson($processo->asArray());
    }

    /**
     * Lista de todas as testemunhas de um processo
     * rota: GET /processo/testemulhas?id={processo_id}
     */
    public function actionTestemunhas($id)
    {
        $processo = Processo::findOneById($id);

        $testemunhas = $processo->getTestemunas();

        $arary = [];
        foreach ($testemunhas as $t) $array[] = $t->asArray();

        return $this->asJson($array);
    }
}
