<?php

namespace backend\modules\Block\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\services\FileService;
use common\actions\web as Actions;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\modelsSearch\BlockPageSearch;
use backend\modules\Block\models\BlockType;
use backend\modules\Block\models\Block;
use backend\modules\Block\models\BlockImage;


class PageController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new BlockPageSearch(),
            ],
            'create' => [
                'class' => Actions\UpdateAction::className(),
                'model' => new BlockPage(),
                'view' => 'assign',
                'params' => [
                    'types' => BlockType::find()->all(),
                ],
            ],
            'assign' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->assign(),
                'view' => 'assign',
                'params' => [
                    'types' => BlockType::find()->all(),
                ],
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new BlockPage(),
            ],
        ];
    }
    
    private function assign()
    {
        return BlockPage::findOne(Yii::$app->request->get('id'));
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
    
    public function actionImageSort($id)
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
    
    public function actionImageDelete($id)
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
