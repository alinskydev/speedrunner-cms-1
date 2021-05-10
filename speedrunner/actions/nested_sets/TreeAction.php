<?php

namespace speedrunner\actions\nested_sets;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class TreeAction extends Action
{
    public $filter = ['depth' => 0];
    
    public $render_view = 'tree';
    public ?\Closure $render_params;
    
    public function run()
    {
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params = $this->render_params ?? fn() => [];
        
        return call_user_func(
            [$this->controller, $render_type],
            $this->render_view,
            ArrayHelper::merge([
                'data' => $this->controller->model->find()->andWhere($this->filter)->one()->tree(),
            ], $render_params())
        );
    }
}
