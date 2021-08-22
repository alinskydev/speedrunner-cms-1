<?php

namespace speedrunner\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use speedrunner\actions as Actions;
use speedrunner\db\ActiveRecord;


class NestedSetsController extends Controller
{
    public ActiveRecord $model;
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-with-children' => ['post'],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\nested_sets\IndexAction::className(),
            ],
            'create' => [
                'class' => Actions\nested_sets\CreateAction::className(),
                'render_params' => fn() => [
                    'parents' => $this->model->find()->itemsTree('name', 'translation', null, null)->asArray()->all(),
                ],
            ],
            'update' => [
                'class' => Actions\nested_sets\UpdateAction::className(),
            ],
            'delete' => [
                'class' => Actions\nested_sets\DeleteAction::className(),
                'run_method' => 'delete',
            ],
            'delete-with-children' => [
                'class' => Actions\nested_sets\DeleteAction::className(),
                'run_method' => 'deleteWithChildren',
            ],
            'move' => [
                'class' => Actions\nested_sets\MoveAction::className(),
            ],
            'expand' => [
                'class' => Actions\nested_sets\ExpandAction::className(),
            ],
        ];
    }
    
    public function findModel($id)
    {
        return $this->model->find()->withoutRoots()->andWhere(['id' => $id])->one();
    }
    
    public function findSecondModel($id)
    {
        return $this->model->find()->withoutRoots()->andWhere(['id' => $id])->one();
    }
}
