<?php

namespace common\actions\crud;

use Yii;
use common\actions\web\FormAction;
use yii\helpers\ArrayHelper;


class UpdateAction extends FormAction
{
    public string $render_view = 'update';
    
    public string $run_method = 'save';
    public ?string $success_message = 'Record has been saved';
    public $redirect_route = ['index'];
    
    public function run()
    {
        if (!($model = $this->controller->findModel())) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $this->model = $model;
        return parent::run();
    }
}
