<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\controllers\RestController as Controller;

use backend\modules\Staticpage\models\Staticpage;


class StaticpageController extends Controller
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
        if ($model = StaticPage::find()->andWhere(['name' => $name])->one()) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException;
        }
    }
}
