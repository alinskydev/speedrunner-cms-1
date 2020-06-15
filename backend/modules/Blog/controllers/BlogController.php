<?php

namespace backend\modules\Blog\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\Blog;
use backend\modules\Blog\modelsSearch\BlogSearch;
use backend\modules\Blog\modelsSearch\BlogCommentSearch;
use backend\modules\Blog\modelsSearch\BlogRateSearch;


class BlogController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlogSearch);
    }
    
    public function actionView($id)
    {
        if ($model = Blog::findOne($id)) {
            $search_models = [
                'comments' => new BlogCommentSearch,
                'rates' => new BlogRateSearch
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
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new Blog);
    }
    
    public function actionUpdate($id)
    {
        $model = Blog::find()->with(['tags'])->where(['id' => $id])->one();
        
        if ($model) {
            $model->tags_tmp = $model->tags;
            
            return Yii::$app->sr->record->updateModel($model);
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Blog);
    }
    
    public function actionItemsList($q = '')
    {
        $out['results'] = Blog::itemsList('name', 'translation', 20, $q);
        return $this->asJson($out);
    }
    
    public function actionImageDelete($id)
    {
        if (!($model = Blog::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->images;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes(['images' => array_values($images)]);
        }
    }
    
    public function actionImageSort($id)
    {
        if (!($model = Blog::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->images;
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes(['images' => array_values($images)]);
    }
}
