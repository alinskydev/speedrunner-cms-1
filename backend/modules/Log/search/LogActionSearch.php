<?php

namespace backend\modules\Log\search;

use Yii;
use backend\modules\Log\models\LogAction;


class LogActionSearch extends LogAction
{
    public $attrs_old;
    public $attrs_new;
    
    public function rules()
    {
        return [
            [['id', 'user_id', 'model_id'], 'integer'],
            [['type', 'model_class', 'created_at'], 'safe'],
            [['attrs_old', 'attrs_new'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = LogAction::find()
            ->joinWith(['attrs'])
            ->with(['user'])
            ->groupBy('log_action.id');
        
        $attribute_groups = [
            '=' => ['log_action.id', 'log_action.user_id', 'log_action.model_class', 'log_action.model_id'],
            'like' => ['log_action.type', 'attrs_old' => 'log_action_attr.name', 'attrs_new' => 'log_action_attr.name'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}