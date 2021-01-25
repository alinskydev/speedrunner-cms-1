<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

use backend\modules\Staticpage\models\Staticpage;


class StaticpageController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionView($name)
    {
        if ($model = StaticPage::find()->andWhere(['name' => $name])->one()) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}
