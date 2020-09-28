<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\modelsSearch\SystemLanguageSearch;


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
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new SystemLanguageSearch;
        $dataProvider = $searchModel->search([$searchModel->formName() => Yii::$app->request->get('filter')]);
        
        return [
            'data' => $dataProvider,
            'links' => $dataProvider->pagination->getLinks(true),
        ];
    }
}
