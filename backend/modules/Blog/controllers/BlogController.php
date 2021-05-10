<?php

namespace backend\modules\Blog\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\Blog;
use backend\modules\Blog\models\BlogComment;
use backend\modules\Blog\models\BlogRate;


class BlogController extends CrudController
{
    public function init()
    {
        $this->model = new Blog();
        return parent::init();
    }
    
    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
        
        return ArrayHelper::merge($actions, [
            'file-sort' => [
                'class' => Actions\crud\FileSortAction::className(),
                'allowed_attributes' => ['images'],
            ],
            'file-delete' => [
                'class' => Actions\crud\FileDeleteAction::className(),
                'allowed_attributes' => ['images'],
            ],
        ]);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['tags'])->andWhere(['id' => $id])->one();
    }
    
    public function actionView($id)
    {
        if (!($model = $this->model->findOne($id))) {
            return $this->redirect(['index']);
        }
        
        $models = [
            'comments' => new BlogComment(),
            'rates' => new BlogRate(),
        ];
        
        foreach ($models as $key => $m) {
            $searchModel[$key] = $m->searchModel;
            $searchModel[$key]->enums = $m->enums;
            $dataProvider[$key] = $searchModel[$key]->search(Yii::$app->request->queryParams);
            $dataProvider[$key]->pagination->pageParam = "dp_$key";
            $dataProvider[$key]->pagination->pageSize = 20;
            $dataProvider[$key]->sort->sortParam = "dp_$key-sort";
            $dataProvider[$key]->query->andWhere(['blog_id' => $id]);
        }
        
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
