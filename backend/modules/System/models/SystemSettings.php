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
            [['label'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 1000],
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
}
