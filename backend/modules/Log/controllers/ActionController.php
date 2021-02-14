<?php

namespace backend\modules\Log\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Log\models\LogAction;
use backend\modules\Log\search\LogActionSearch;
use backend\modules\Log\lists\LogActionList;


class ActionController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new LogAction();
        $this->modelSearch = new LogActionSearch();
        
        return parent::beforeAction($action);
    }
    
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
        $actions = ArrayHelper::filter(parent::actions(), ['view']);
        
        return ArrayHelper::merge($actions, [
            'index' => [
                'class' => Actions\crud\DataProviderAction::className(),
                'render_params' => [
                    'log_action_modules_list' => (new LogActionList)::$models,
                ]
            ],
        ]);
    }
    
    public function findModel()
    {
        return LogAction::find()->with(['attrs'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
