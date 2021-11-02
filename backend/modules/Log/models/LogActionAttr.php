<?php

namespace backend\modules\Log\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use speedrunner\validators\EitherValidator;


class LogActionAttr extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%log_action_attr}}';
    }
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['required'],
                ['string', 'max' => 100],
                [
                    'in',
                    'not' => true,
                    'range' => [
                        'id', 'created_at', 'updated_at',
                    ],
                ],
            ],
            'value_old' => [
                [EitherValidator::className(), 'either_attributes' => ['value_new']],
            ],
            'value_new' => [
                [EitherValidator::className(), 'either_attributes' => ['value_old']],
            ],
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
