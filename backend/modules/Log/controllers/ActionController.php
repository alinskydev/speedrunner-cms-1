<?php

namespace backend\modules\Log\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Log\models\LogAction;
use backend\modules\Log\modelsSearch\LogActionSearch;
use backend\modules\Log\lists\LogActionModelsList;


class ActionController extends Controller
{
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => \yii\filters\PageCache::className(),
                'duration' => 0,
                'only' => ['index', 'view'],
                'dependency' => [
                    'class' => \yii\caching\DbDependency::className(),
                    'sql' => LogAction::find()->select('COUNT(*)')->createCommand()->getRawSql(),
                ],
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user,
                    Yii::$app->request->get(),
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new LogActionSearch(),
                'params' => [
                    'log_action_modules_list' => (new LogActionModelsList)::$models,
                ]
            ],
        ];
    }
    
    public function actionView($id)
    {
        $model = LogAction::find()->with(['attrs'])->andWhere(['id' => $id])->one();
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        return $this->renderAjax('view', [
            'model' => $model,
        ]);
    }
}
