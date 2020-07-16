<?php

namespace backend\modules\Menu\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\Menu\models\Menu;


class MenuController extends Controller
{
    public function actionTree($id = 1)
    {
        return $this->render('tree', [
            'data' => Menu::findOne($id)->tree(),
        ]);
    }
    
    public function actionCreate()
    {
        $model = new Menu;
        
        if ($model->load(Yii::$app->request->post()) && $model->makeRoot()) {
            if ($parent = Menu::findOne($model->parent_id)) {
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
        if (!in_array($id, [1])) {
            $model = Menu::findOne($id);
            
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['tree']);
            }
            
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        } else {
            $this->redirect(['tree']);
        }
    }
    
    public function actionDelete($id)
    {
        if (!in_array($id, [1])) {
            Menu::findOne($id)->delete();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionDeleteWithChildren($id)
    {
        if (!in_array($id, [1])) {
            Menu::findOne($id)->deleteWithChildren();
        }
        
        return $this->redirect(['tree']);
    }
    
    public function actionMove($item, $action, $second)
    {
        if (!in_array($item, [1])) {
            $item_model = Menu::findOne($item);
            $second_model = Menu::findOne($second);
            
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
        } else {
            return false;
        }
    }
    
    public function actionExpandStatus($item)
    {
        $item_model = Menu::findOne($item);
        $item_model->expanded = intval(!$item_model->expanded);
        
        return $item_model->save();
    }
}
