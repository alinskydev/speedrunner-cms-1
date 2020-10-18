<?php

namespace backend\modules\Block\controllers;

use Yii;
use yii\web\Controller;
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
        return Yii::$app->sr->record->updateModel(new BlockPage, 'assign', [
            'types' => BlockType::find()->all(),
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = BlockPage::find()->with(['blocks', 'blocks.type'])->andWhere(['id' => $id])->one();
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($post_data = Yii::$app->request->post('Block')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                if ($relation_mdl = ArrayHelper::getValue($blocks, $key)) {
                    $relation_mdl->value = ArrayHelper::getValue($p_d, 'value');
                    $relation_mdl->save();
                }
            }
            
            if (Yii::$app->request->get('reload-page')) {
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
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
        if (!($model = BlockPage::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        return Yii::$app->sr->record->updateModel($model, 'assign', [
            'types' => BlockType::find()->all(),
        ]);
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
}
