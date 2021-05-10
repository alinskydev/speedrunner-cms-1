<?php

namespace speedrunner\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class ViewAction extends Action
{
    public Model $model;
    
    public ?string $render_view = 'view';
    public ?\Closure $render_params;
    
    public function run($id)
    {
        $model = $this->model ?? $this->controller->findModel($id);
        
        if (!$model) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params = $this->render_params ?? fn() => [];
        
        return call_user_func(
            [$this->controller, $render_type],
            $this->render_view,
            ArrayHelper::merge([
                'model' => $model,
            ], $render_params())
        );
    }
}
