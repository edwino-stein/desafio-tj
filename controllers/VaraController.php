<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Vara;

class VaraController extends Controller
{

    /**
     * Lista as varas
     * Rota: GET /vara
     */
    public function actionIndex()
    {
        $data = [];
        $varas = Vara::fetchAll();
        foreach ($varas as $v) $data[] = $v->asArray();
        return $this->asJson($data);
    }

    /**
     * Ler as informações de uma unica vara
     * Rota: GET /vara/info?id={vara_id}
     */
    public function actionInfo($id)
    {
        $vara = Vara::findOneById($id);
        return $this->asJson($vara->asArray());
    }

    /**
     * Sorteia um juiz da vara
     * Rota: GET /vara/sorteio?id={vara_id}
     */
    public function actionSorteio($id)
    {
        $vara = Vara::findOneById($id);
        $juiz = $vara->sortearJuiz();

        if($juiz == null) throw new \Exception("Não foi possivel sortear um juiz", 1);

        $vara->setUltimoSorteado($juiz);
        $vara->save();

        return $this->asJson($juiz->asArray());
    }
}
