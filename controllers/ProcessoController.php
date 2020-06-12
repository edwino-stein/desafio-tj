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
}
