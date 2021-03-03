<?php

namespace backend\modules\Log\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\JsonExpression;


class LogActionAttr extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%log_action_attr}}';
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value_old'], 'required', 'when' => fn ($model) => empty($model->value_new)],
            [['value_new'], 'required', 'when' => fn ($model) => empty($model->value_old)],
            [['name'], 'string', 'max' => 100],
            
            [['name'], 'in', 'not' => true, 'range' => [
                'id', 'created_at', 'updated_at',
            ]],
        ];
    }
    
    public function getAction()
    {
        return $this->hasOne(LogAction::className(), ['id' => 'action_id']);
    }
    
    public function beforeSave($insert)
    {
        $this->value_old = $this->value_old ?: (is_array($this->value_old) ? [] : '');
        $this->value_new = $this->value_new ?: (is_array($this->value_new) ? [] : '');
        
        return parent::beforeSave($insert);
    }
}
