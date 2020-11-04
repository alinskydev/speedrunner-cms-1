<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

use backend\modules\System\models\SystemSettings;
use backend\modules\System\modelsSearch\SystemSettingsSearch;


class SettingsController extends Controller
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
                    'index' => ['get'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new SystemSettingsSearch;
        $dataProvider = $searchModel->search([$searchModel->formName() => Yii::$app->request->get('filter')]);
        $dataProvider->query->andWhere(['not in', 'name', ['delete_model_file']]);
        $dataProvider->pagination->totalCount = $dataProvider->query->count();
        
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
