<?php

namespace backend\modules\Block\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\modelsSearch\BlockPageSearch;
use backend\modules\Block\models\BlockType;
use backend\modules\Block\models\Block;
use backend\modules\Block\models\BlockImage;


class PageController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new BlockPageSearch);
    }
    
    public function actionCreate()
    {
        $render_params = [
            'types' => BlockType::find()->all(),
        ];
        
        return Yii::$app->sr->record->updateModel(new BlockPage, 'assign', $render_params);
    }
    
    public function actionUpdate($id)
    {
        $model = BlockPage::find()->with(['blocks.translation', 'blocks.type', 'blocks.images'])->where(['id' => $id])->one();
        
        if ($post_data = Yii::$app->request->post('Block')) {
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
            
            if (Yii::$app->request->isAjax) {
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        
        $blocks = $model->blocks;
        
        return $this->render('update', [
            'model' => $model,
            'blocks' => $blocks,
        ]);
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new BlockPage);
    }
    
    public function actionAssign($id)
    {
        if ($model = BlockPage::findOne($id)) {
            $render_params = [
                'types' => BlockType::find()->all(),
            ];
            
            return Yii::$app->sr->record->updateModel($model, 'assign', $render_params);
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function actionImageDelete()
    {
        if (($model = BlockImage::findOne(Yii::$app->request->post('key'))) && $model->delete()) {
            return true;
        }
    }
    
    public function actionImageSort($id)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            
            if ($post['oldIndex'] > $post['newIndex']) {
                $params = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $counter = 1;
            } else {
                $params = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $counter = -1;
            }
            
            BlockImage::updateAllCounters(['sort' => $counter], [
               'and', ['item_id' => $id], $params
            ]);
            
            BlockImage::updateAll(['sort' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            
            return true;
        }
    }
}
