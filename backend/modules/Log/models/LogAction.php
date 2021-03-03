<?php

namespace backend\modules\Log\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use backend\modules\Log\lists\LogActionModelsList;
use backend\modules\User\models\User;


class LogAction extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%log_action}}';
    }

    public function rules()
    {
        return [
            [['type', 'model_class'], 'required'],
            [['type'], 'in', 'range' => array_keys($this->enums->types())],
            [['model_class'], 'in', 'range' => array_keys((new LogActionModelsList)::$data)],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'user_id' => Yii::t('app', 'User'),
            'type' => Yii::t('app', 'Type'),
            'model_class' => Yii::t('app', 'Action'),
            'model_id' => Yii::t('app', 'Action'),
            'created_at' => Yii::t('app', 'Created at'),
            
            'attrs_old' => Yii::t('app', 'Old value'),
            'attrs_new' => Yii::t('app', 'New value'),
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getAttrs()
    {
        return $this->hasMany(LogActionAttr::className(), ['action_id' => 'id']);
    }
}
