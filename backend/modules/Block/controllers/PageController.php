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
        $model = BlockPage::find()->with(['blocks', 'blocks.type'])->where(['id' => $id])->one();
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($post_data = Yii::$app->request->post('Block')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                $block_mdl = $blocks[$key];
                
                if (isset($p_d['value'])) {
                    $block_mdl->value = $p_d['value'];
                }
                
                $block_mdl->save();
            }
            
            return $this->redirect(['index']);
        }
        
        return $this->render('update', [
            'model' => $model,
            'blocks' => $model->blocks,
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
    
    public function actionImageDelete($id)
    {
        if (!($model = Block::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->value;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            if ($model->type->has_translation) {
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
        if (!($model = Block::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->value;
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        if ($model->type->has_translation) {
            $json = ArrayHelper::getValue($model->oldAttributes, 'value');
            $json[Yii::$app->language] = array_values($images);
            
            return $model->updateAttributes(['value' => $json]);
        } else {
            return $model->updateAttributes(['value' => array_values($images)]);
        }
    }
}
