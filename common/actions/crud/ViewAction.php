<?php

namespace common\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class ViewAction extends Action
{
    public $render_view = 'view';
    public array $render_params = [];
    
    public function run()
    {
        if (!($model = $this->controller->findModel())) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $render_params = ['model' => $model];
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return $this->controller->{$render_type}($this->render_view, ArrayHelper::merge($render_params, $this->render_params));
    }
}
