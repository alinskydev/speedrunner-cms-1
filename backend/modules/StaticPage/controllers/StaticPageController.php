<?php

namespace backend\modules\StaticPage\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\StaticPage\models\StaticPage;
use backend\modules\StaticPage\models\StaticPageBlock;
use backend\modules\StaticPage\models\StaticPageBlockImage;


class StaticPageController extends Controller
{
    public function actionUpdate($location)
    {
        $model = StaticPage::find()->with(['blocks', 'blocks.images'])->where(['location' => $location])->one();
        
        if ($post_data = Yii::$app->request->post('StaticPageBlock')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                $block_mdl = $blocks[$key];
                
                if (isset($p_d['value'])) {
                    $block_mdl->value = $p_d['value'];
                }
                
                if (isset($p_d['images_tmp'])) {
                    $block_mdl->images_tmp = $p_d['images_tmp'];
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
    
    public function actionImageDelete()
    {
        if (($model = StaticPageBlockImage::findOne(Yii::$app->request->post('key'))) && $model->delete()) {
            return true;
        }
    }
    
    public function actionImageSort($id)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            
            if ($post['oldIndex'] > $post['newIndex']){
                $params = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $counter = 1;
            } else {
                $params = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $counter = -1;
            }
            
            StaticPageBlockImage::updateAllCounters(['sort' => $counter], [
               'and', ['item_id' => $id], $params
            ]);
            
            StaticPageBlockImage::updateAll(['sort' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            
            return true;
        }
    }
}
