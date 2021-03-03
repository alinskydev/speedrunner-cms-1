<?php

namespace backend\modules\Log\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Log\models\LogAction;
use backend\modules\Log\lists\LogActionModelsList;


class ActionController extends CrudController
{
    public function init()
    {
        $this->model = new LogAction();
        return parent::init();
    }
    
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => \yii\filters\PageCache::className(),
                'only' => ['index', 'view'],
                'duration' => 0,
                'dependency' => [
                    'class' => \yii\caching\DbDependency::className(),
                    'sql' => LogAction::find()->select('MAX(id)')->createCommand()->getRawSql(),
                ],
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user->id,
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
                    'log_action_models_list' => (new LogActionModelsList())::$data,
                ]
            ],
        ]);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['attrs'])->andWhere(['id' => $id])->one();
    }
}
