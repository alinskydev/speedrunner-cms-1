<?php

namespace backend\modules\System\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class SystemSettings extends ActiveRecord
{
    public $service = false;
    
    public static function tableName()
    {
        return 'SystemSettings';
    }
    
    public function rules()
    {
        return [
            [['value'], 'string', 'max' => '100', 'when' => function ($model) {
                return in_array($model->type, ['text_input', 'text_area', 'imperavi', 'elfinder']);
            }],
            [['value'], 'boolean', 'when' => function ($model) {
                return in_array($model->type, ['checkbox']);
            }],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
