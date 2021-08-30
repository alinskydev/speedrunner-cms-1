<?php

namespace speedrunner\actions\nested_sets;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class ExpandAction extends Action
{
    public string $model_class;
    
    public function run($id)
    {
        if (!($model = $this->controller->findExpandModel($id))) {
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
        
        $expanded = Yii::$app->session->get('expanded', []);
        $expanded_set = ArrayHelper::getValue($expanded, StringHelper::basename($model->className()), []);
        
        if (isset($expanded_set[$id])) {
            unset($expanded_set[$id]);
        } else {
            $expanded_set[$id] = $id;
        }
        
        $expanded[StringHelper::basename($model->className())] = $expanded_set;
        return Yii::$app->session->set('expanded', $expanded);
    }
}
