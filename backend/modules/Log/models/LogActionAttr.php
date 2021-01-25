<?php

namespace backend\modules\Log\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\JsonExpression;


class LogActionAttr extends ActiveRecord
{
    public static function tableName()
    {
        return 'LogActionAttr';
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['value_old'], 'required', 'when' => fn ($model) => empty($model->value_new)],
            [['value_new'], 'required', 'when' => fn ($model) => empty($model->value_old)],
            [['name'], 'string', 'max' => 100],
            
            [['name'], 'in', 'not' => true, 'range' => [
                'id', 'created', 'updated',
            ]],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'action_id' => Yii::t('app', 'Action'),
            'name' => Yii::t('app', 'Name'),
            'value_old' => Yii::t('app', 'Old value'),
            'value_new' => Yii::t('app', 'New value'),
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
