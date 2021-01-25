<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Product\models\ProductCategory;


class CategoryController extends Controller
{
    public function actionTree()
    {
        return $this->render('tree', [
            'data' => ProductCategory::find()->andWhere(['depth' => 0])->one()->tree(),
        ]);
    }
    
    public function actionCreate()
    {
        $model = new ProductCategory();
        
        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()) {
            if ($parent = ProductCategory::findOne($model->parent_id)) {
                $model->refresh();
                $model->appendTo($parent);
            }
            
            return $this->redirect(['tree']);
        }
        
        return $this->renderAjax('update', [
            'model' => $model,
            'categories_list' => ProductCategory::find()->itemsTree('name', 'translation'),
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = ProductCategory::find()->with(['specifications'])->andWhere(['id' => $id])->one();
        
        if (!$model || $model->depth == 0) {
            return $this->redirect(['tree']);
        }
        
        $model->specifications_tmp = $model->specifications;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['tree']);
        }
        
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
        $model = ProductCategory::findOne($id);
        
        if ($model && $model->depth > 0) {
            $model->delete();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionDeleteWithChildren($id)
    {
        $model = ProductCategory::findOne($id);
        
        if ($model && $model->depth > 0) {
            $model->deleteWithChildren();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionMove($item, $action, $second)
    {
        $item_model = ProductCategory::findOne($item);
        $second_model = ProductCategory::findOne($second);
        
        if ($item_model && $item_model->depth > 0 && $second_model && $second_model->depth > 0) {
            switch ($action) {
                case 'after':
                    $item_model->insertAfter($second_model);
                    break;
                case 'before':
                    $item_model->insertBefore($second_model);
                    break;
                case 'over':
                    $item_model->appendTo($second_model);
                    break;
            }
            
            return true;
        }
        
        return false;
    }
    
    public function actionExpand($id)
    {
        $model = ProductCategory::findOne($id);
        return $model ? $model->updateAttributes(['expanded' => intval(!$model->expanded)]) : false;
    }
}
