<?php

namespace backend\modules\Gallery\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Gallery\models\Gallery;
use backend\modules\Gallery\modelsSearch\GallerySearch;
use backend\modules\Gallery\models\GalleryImage;


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
    
    public function actionImageDelete()
    {
        if (($model = GalleryImage::findOne(Yii::$app->request->post('key'))) && $model->delete()) {
            return true;
        }
    }
    
    public function actionImageSort($id)
    {
        if (Yii::$app->request->isAjax){
            $post = Yii::$app->request->post('sort');
            
            if ($post['oldIndex'] > $post['newIndex']) {
                $param = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $counter = 1;
            } else {
                $param = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $counter = -1;
            }
            
            GalleryImage::updateAllCounters(['sort' => $counter], [
               'and', ['item_id' => $id], $param
            ]);
            
            GalleryImage::updateAll(['sort' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            
            return true;
        }
    }
}
