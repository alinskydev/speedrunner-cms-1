<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\modelsSearch\SystemLanguageSearch;


class ListController extends Controller
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
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'languages' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionLanguages()
    {
        $searchModel = new SystemLanguageSearch;
        $dataProvider = $searchModel->search([$searchModel->formName() => Yii::$app->request->get('filter')]);
        
        return [
            'data' => $dataProvider,
            'links' => $dataProvider->pagination->getLinks(true),
            'pagination' => [
                'total_count' => (int)$dataProvider->pagination->totalCount,
                'page_count' => $dataProvider->pagination->pageCount,
                'current_page' => $dataProvider->pagination->page + 1,
                'page_size' => $dataProvider->pagination->pageSize,
            ],
        ];
    }
}
