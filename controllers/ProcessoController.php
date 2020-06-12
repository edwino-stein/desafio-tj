<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Processo;

class ProcessoController extends Controller
{

    public $enableCsrfValidation = false;

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
}
