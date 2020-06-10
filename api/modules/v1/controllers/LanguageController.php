<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use yii\filters\VerbFilter;
use xtomdex\widgets\CountrySelect;

use api\modules\v1\models\SystemLanguage;


class LanguageController extends Controller
{
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
            'query' => SystemLanguage::find(),
        ]);
    }
    
    public function actionView($id)
    {
        if ($model = SystemLanguage::findOne($id)) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException();
        }
    }
}
