<?php

namespace backend\modules\Staticpage\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\services\FileService;

use backend\modules\Staticpage\models\Staticpage;
use backend\modules\Staticpage\models\StaticpageBlock;


class StaticpageController extends Controller
{
    public function actionUpdate($name)
    {
        $model = Staticpage::find()->with(['blocks'])->andWhere(['name' => $name])->one();
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($post_data = Yii::$app->request->post('StaticpageBlock')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                if ($relation_mdl = ArrayHelper::getValue($blocks, $key)) {
                    $relation_mdl->value = ArrayHelper::getValue($p_d, 'value');
                    $relation_mdl->save();
                }
            }
        }
        
        if (Yii::$app->request->post('SeoMeta')) {
            $model->save();
        }
        
        if (Yii::$app->request->isPost) {
            return $this->refresh();
        }
        
        return $this->render('update', [
            'model' => $model,
            'blocks' => ArrayHelper::index($model->blocks, null, 'part_name'),
        ]);
    }
    
    public function actionImageSort($id)
    {
        if (!($model = StaticpageBlock::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $stack = Yii::$app->request->post('sort')['stack'] ?? [];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        if ($model->has_translation) {
            $json = ArrayHelper::getValue($model->oldAttributes, 'value');
            $json[Yii::$app->language] = array_values($images);
            
            return $model->updateAttributes(['value' => $json]);
        } else {
            return $model->updateAttributes(['value' => array_values($images)]);
        }
    }
    
    public function actionImageDelete($id)
    {
        if (!($model = StaticpageBlock::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->value;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            FileService::delete($images[$key]);
            unset($images[$key]);
            
            if ($model->has_translation) {
                $json = ArrayHelper::getValue($model->oldAttributes, 'value');
                $json[Yii::$app->language] = array_values($images);
                
                return $model->updateAttributes(['value' => $json]);
            } else {
                return $model->updateAttributes(['value' => array_values($images)]);
            }
        }
    }
}
