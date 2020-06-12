<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Tela de listagem de processos
     * Rota: / ou /site/index
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Tela para visualizar um processo em detalhes
     * Rota: /site/verprocesso?id={processo_id}
     */
    public function actionVerprocesso()
    {
        return $this->render('verprocesso');
    }
}
