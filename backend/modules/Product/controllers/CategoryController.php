<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Product\models\ProductCategory;


class CategoryController extends Controller
{
    public function actionTree($id = 1)
    {
        return $this->render('tree', [
            'data' => ProductCategory::findOne($id)->tree(),
        ]);
    }
    
    public function actionCreate()
    {
        $model = new ProductCategory;
        
        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()) {
            if ($parent = ProductCategory::findOne($model->parent_id)) {
                $model->refresh();
                $model->appendTo($parent);
            }
            
            return $this->redirect(['tree']);
        }
        
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = ProductCategory::find()->with(['attrs'])->where(['id' => $id])->one();
        $model->attrs_tmp = $model->attrs;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['tree']);
        }
        
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
        if ($id != 1) {
            ProductCategory::findOne($id)->delete();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionDeleteWithChildren($id)
    {
        if ($id != 1) {
            ProductCategory::findOne($id)->deleteWithChildren();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionMove($item, $action, $second)
    {
        if ($item != 1) {
            $item_model = ProductCategory::findOne($item);
            $second_model = ProductCategory::findOne($second);
            
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
            
            $item_model->save(false);
            
            return true;
        } else {
            return false;
        }
    }
    
    public function actionExpandStatus($item)
    {
        $item_model = ProductCategory::findOne($item);
        $item_model->expanded = intval(!$item_model->expanded);
        
        return $item_model->save();
    }
}
