<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error',
            ],
        ];
    }
    
    public function actionIndex()
    {
        $this->layout = 'index';
        return $this->render('index');
    }
}
