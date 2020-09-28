<?php

namespace backend\modules\Gallery\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Gallery\models\Gallery;
use backend\modules\Gallery\modelsSearch\GallerySearch;


class GalleryController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new GallerySearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new Gallery);
    }
    
    public function actionUpdate($id)
    {
        $model = Gallery::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Gallery);
    }
    
    public function actionImageSort($id, $attr)
    {
        if (!in_array($attr, ['images'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = Gallery::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->{$attr};
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes([$attr => array_values($images)]);
    }
    
    public function actionImageDelete($id, $attr)
    {
        if (!in_array($attr, ['images'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = Gallery::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->{$attr};
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes([$attr => array_values($images)]);
        }
    }
}
