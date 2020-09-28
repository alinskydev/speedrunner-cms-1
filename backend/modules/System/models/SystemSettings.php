<?php

namespace backend\modules\System\models;

use Yii;
use common\components\framework\ActiveRecord;


class SystemSettings extends ActiveRecord
{
    public static function tableName()
    {
        return 'SystemSettings';
    }
    
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['sort'], 'integer'],
            [['label', 'value'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
    
    public function fields()
    {
        return [
            'id',
            'name',
            'label',
            'value',
        ];
    }
}
