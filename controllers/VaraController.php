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
}
