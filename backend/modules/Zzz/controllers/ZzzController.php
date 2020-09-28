<?php

namespace backend\modules\Zzz\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Zzz\models\Zzz;
use backend\modules\Zzz\modelsSearch\ZzzSearch;


class ZzzController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ZzzSearch);
    }
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new Zzz);
    }
    
    public function actionUpdate($id)
    {
        $model = Zzz::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Zzz);
    }
    
    public function actionImageSort($id, $attr)
    {
        if (!in_array($attr, ['images'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = Zzz::findOne($id))) {
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
        
        if (!($model = Zzz::findOne($id))) {
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
