<?php

namespace api\modules\v1\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Staticpage\models\Staticpage;


class StaticpageController extends RestController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ]);
    }
    
    public function actionView($name)
    {
        if ($model = StaticPage::find()->with(['blocks'])->andWhere(['name' => $name])->one()) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('Entity not found');
        }
    }
}
