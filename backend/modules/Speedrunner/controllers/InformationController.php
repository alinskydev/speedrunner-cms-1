<?php

namespace backend\modules\Speedrunner\controllers;

use Yii;
use yii\web\Controller;


class InformationController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
