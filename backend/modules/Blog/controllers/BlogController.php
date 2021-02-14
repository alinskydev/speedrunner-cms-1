<?php

namespace backend\modules\Blog\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\Blog;
use backend\modules\Blog\search\BlogSearch;
use backend\modules\Blog\search\BlogCommentSearch;
use backend\modules\Blog\search\BlogRateSearch;


class BlogController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new Blog();
        $this->modelSearch = new BlogSearch();
        
        return parent::beforeAction($action);
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
    
    public function findModel()
    {
        return Blog::find()->with(['tags'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
    
    public function actionView($id)
    {
        if ($model = Blog::findOne($id)) {
            $search_models = [
                'comments' => new BlogCommentSearch(),
                'rates' => new BlogRateSearch(),
            ];
            
            foreach ($search_models as $key => $s_m) {
                $modelSearch[$key] = $s_m;
                $dataProvider[$key] = $modelSearch[$key]->search(Yii::$app->request->queryParams);
                $dataProvider[$key]->pagination->pageParam = 'dp_' . $key;
                $dataProvider[$key]->pagination->pageSize = 20;
                $dataProvider[$key]->sort->sortParam = 'dp_' . $key . '-sort';
                $dataProvider[$key]->query->andWhere(['blog_id' => $id]);
            }
            
            return $this->render('view', [
                'model' => $model,
                'modelSearch' => $modelSearch,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->redirect(['index']);
        }
    }
}
