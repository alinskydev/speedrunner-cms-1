<?php

namespace speedrunner\actions\nested_sets;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class DeleteAction extends Action
{
    public string $run_method;
    public ?string $success_message = 'Record has been deleted';
    
    public function run($id)
    {
        if (!($model = $this->controller->findModel($id))) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $model->{$this->run_method}();
        
        if ($this->success_message) {
            Yii::$app->session->addFlash('success', Yii::t('app', $this->success_message));
        }
        
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
