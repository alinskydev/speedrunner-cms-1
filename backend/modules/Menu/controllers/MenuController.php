<?php

namespace backend\modules\Menu\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Menu\models\Menu;


class MenuController extends Controller
{
    public function actionTree()
    {
        return $this->render('tree', [
            'data' => Menu::find()->andWhere(['depth' => 0])->one()->tree(),
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Menu();
        
        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()) {
            if ($parent = Menu::findOne($model->parent_id)) {
                $model->refresh();
                $model->appendTo($parent);
            }
            
            return $this->redirect(['tree']);
        }
        
        return $this->renderAjax('update', [
            'model' => $model,
            'menu_list' => Menu::find()->itemsTree('name', 'translation')->asArray()->all(),
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = Menu::findOne($id);
        
        if (!$model || $model->depth == 0) {
            return $this->redirect(['tree']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['tree']);
        }
        
        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
        $model = Menu::findOne($id);
        
        if ($model && $model->depth > 0) {
            $model->delete();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionDeleteWithChildren($id)
    {
        $model = Menuz::findOne($id);
        
        if ($model && $model->depth > 0) {
            $model->deleteWithChildren();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionMove($item, $action, $second)
    {
        $item_model = Menu::findOne($item);
        $second_model = Menu::findOne($second);
        
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
        $model = Menu::findOne($id);
        return $model ? $model->updateAttributes(['expanded' => intval(!$model->expanded)]) : false;
    }
}
