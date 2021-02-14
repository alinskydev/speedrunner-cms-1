<?php

namespace backend\modules\Block\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;
use common\services\FileService;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\search\BlockPageSearch;
use backend\modules\Block\models\BlockType;
use backend\modules\Block\models\Block;


class PageController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new BlockPage();
        $this->modelSearch = new BlockPageSearch();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        $block_types = BlockType::find()->all();
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'delete']);
        
        return ArrayHelper::merge($actions, [
            'create' => [
                'class' => Actions\crud\CreateAction::className(),
                'render_view' => 'assign',
                'render_params' => [
                    'types' => $block_types,
                ],
            ],
            'assign' => [
                'class' => Actions\crud\UpdateAction::className(),
                'render_view' => 'assign',
                'render_params' => [
                    'types' => $block_types,
                ],
            ],
        ]);
    }
    
    public function findModel()
    {
        return BlockPage::find()->with(['blocks.type'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
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
            
            if (Yii::$app->request->get('save-and-update')) {
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'blocks' => $model->blocks,
            'new_block' => new Block,
        ]);
    }
    
    public function actionFileSort($id)
    {
        if (!($model = Block::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $stack = Yii::$app->request->post('sort')['stack'] ?? [];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        if ($model->type->has_translation) {
            $json = ArrayHelper::getValue($model->oldAttributes, 'value');
            $json[Yii::$app->language] = array_values($images);
            
            return $model->updateAttributes(['value' => $json]);
        } else {
            return $model->updateAttributes(['value' => array_values($images)]);
        }
    }
    
    public function actionFileDelete($id)
    {
        if (!($model = Block::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->value;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            FileService::delete($images[$key]);
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
