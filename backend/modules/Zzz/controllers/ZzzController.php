<?php

namespace backend\modules\Zzz\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Zzz\models\Zzz;
use backend\modules\Zzz\modelsSearch\ZzzSearch;
use backend\modules\Zzz\models\ZzzImage;


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
    
    public function actionImageDelete()
    {
        if (($model = ZzzImage::findOne(Yii::$app->request->post('key'))) && $model->delete()) {
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
            
            ZzzImage::updateAllCounters(['sort' => $counter], [
               'and', ['item_id' => $id], $param
            ]);
            
            ZzzImage::updateAll(['sort' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            
            return true;
        }
    }
}
