<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;

use api\modules\v1\models\SystemSettings;


class SettingsController extends Controller
{
    const EXCEPTIONS = ['is_mobile_grid', 'delete_model_file'];
    
    public function behaviors()
    {
        return [
            'format' => [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formatParam' => 'format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => SystemSettings::find()->where(['not in', 'name', self::EXCEPTIONS]),
        ]);
    }
    
    public function actionView($id)
    {
        if ($model = SystemSettings::find()->where(['id' => $id])->andWhere(['not in', 'name', self::EXCEPTIONS])->one()) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }
}
