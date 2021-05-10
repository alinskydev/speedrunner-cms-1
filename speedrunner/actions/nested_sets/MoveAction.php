<?php

namespace speedrunner\actions\nested_sets;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class MoveAction extends Action
{
    public function run($first_id, $second_id, $action)
    {
        if (!($first_model = $this->controller->findModel($first_id))) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        if (!($second_model = $this->controller->findSecondModel($second_id))) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        switch ($action) {
            case 'after':
                $first_model->insertAfter($second_model);
                break;
            case 'before':
                $first_model->insertBefore($second_model);
                break;
            case 'over':
                $first_model->appendTo($second_model);
                break;
        }
    }
}
