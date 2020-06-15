<?php

namespace backend\modules\StaticPage\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\StaticPage\models\StaticPage;
use backend\modules\StaticPage\models\StaticPageBlock;


class StaticPageController extends Controller
{
    public function actionUpdate($location)
    {
        $model = StaticPage::find()->with(['blocks'])->where(['location' => $location])->one();
        
        if ($post_data = Yii::$app->request->post('StaticPageBlock')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                $block_mdl = $blocks[$key];
                
                if (isset($p_d['value'])) {
                    $block_mdl->value = $p_d['value'];
                }
                
                $block_mdl->save();
            }
        }
        
        $blocks = $model->blocks ? ArrayHelper::index($model->blocks, null, 'part_name') : [];
        
        if (Yii::$app->request->post('SeoMeta')) {
            $model->save();
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
                'blocks' => $blocks,
            ]);
        }
    }
    
    public function actionImageDelete($id)
    {
        if (!($model = StaticPageBlock::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->value;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
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
    
    public function actionImageSort($id)
    {
        if (!($model = StaticPageBlock::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->value;
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        if ($model->has_translation) {
            $json = ArrayHelper::getValue($model->oldAttributes, 'value');
            $json[Yii::$app->language] = array_values($images);
            
            return $model->updateAttributes(['value' => $json]);
        } else {
            return $model->updateAttributes(['value' => array_values($images)]);
        }
    }
}
