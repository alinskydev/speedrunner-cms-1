<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};
use common\actions\web\{ImageSortAction, ImageDeleteAction};

use backend\modules\Blog\models\Blog;
use backend\modules\Blog\modelsSearch\BlogSearch;
use backend\modules\Blog\modelsSearch\BlogCommentSearch;
use backend\modules\Blog\modelsSearch\BlogRateSearch;


class BlogController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new Blog(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new Blog(),
            ],
            'image-sort' => [
                'class' => ImageSortAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['images'],
            ],
            'image-delete' => [
                'class' => ImageDeleteAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['images'],
            ],
        ];
    }
    
    private function findModel()
    {
        if ($model = Blog::find()->with(['tags'])->andWhere(['id' => Yii::$app->request->get('id')])->one()) {
            $model->tags_tmp = $model->tags;
            return $model;
        }
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
