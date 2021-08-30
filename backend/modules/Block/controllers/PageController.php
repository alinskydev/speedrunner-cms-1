<?php

namespace backend\modules\Block\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\models\BlockType;
use backend\modules\Block\models\Block;


class PageController extends CrudController
{
    public function init()
    {
        $this->model = new BlockPage();
        return parent::init();
    }
    
    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'delete']);
        
        return ArrayHelper::merge($actions, [
            'create' => [
                'class' => Actions\crud\CreateAction::className(),
                'render_view' => 'assign',
                'render_params' => fn() => [
                    'types' => BlockType::find()->orderBy('name')->all(),
                ],
            ],
            'assign' => [
                'class' => Actions\crud\UpdateAction::className(),
                'render_view' => 'assign',
                'render_params' => fn() =>[
                    'types' => BlockType::find()->orderBy('name')->all(),
                ],
            ],
        ]);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['blocks.type'])->andWhere(['id' => $id])->one();
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $model->scenario = 'empty';
        $model->save();
        $model->afterFind();
        
        if ($post_data = Yii::$app->request->post('Block')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                if ($relation_model = ArrayHelper::getValue($blocks, $key)) {
                    $relation_model->value = ArrayHelper::getValue($p_d, 'value');
                    $relation_model->save();
                }
            }
            
            if (Yii::$app->request->get('save_and_update')) {
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
            unset($images[$key]);
            Yii::$app->services->file->delete($images[$key]);
            
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
