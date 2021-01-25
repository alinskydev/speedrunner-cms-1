<?php

namespace common\actions\web;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class DeleteAction extends Action
{
    private $redirect_url;
    
    public $model;
    
    public function init()
    {
        $this->redirect_url = Yii::$app->request->absoluteUrl != Yii::$app->request->referrer ? Yii::$app->request->referrer : ['index'];
        return parent::init();
    }
    
    public function run()
    {
        $id = Yii::$app->request->post('selection') ?? Yii::$app->request->get('id');
        $models = $this->model->find()->andWhere(['id' => $id])->all();
        
        foreach ($models as $m) {
            $m->delete();
        }
        
        return Yii::$app->controller->redirect($this->redirect_url);
    }
}
