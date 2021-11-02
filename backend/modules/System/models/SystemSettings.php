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
        return '{{%system_settings}}';
    }
    
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => \speedrunner\behaviors\CacheBehavior::className(),
                'tags' => ['system_settings'],
            ],
        ];
    }
    
    public function prepareRules()
    {
        return [
            'value' => [
                [
                    'string',
                    'when' => fn($model) => in_array($model->input_type, ['text_input', 'text_area', 'file_manager', 'text_editor']),
                ],
                [
                    'boolean',
                    'when' => fn($model) => in_array($model->input_type, ['checkbox']),
                ],
            ],
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
