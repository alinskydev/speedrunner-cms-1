<?php

namespace backend\modules\System\services;
 
use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\System\models\SystemSettings;


class SystemSettingsService
{
    private static $attributes = null;
    
    public function __construct()
    {
        if (self::$attributes === null) {
            self::$attributes = ArrayHelper::map(SystemSettings::find()->select(['name', 'value'])->asArray()->all(), 'name', 'value');
        }
    }
    
    public function __get($name)
    {
        if (($attribute = ArrayHelper::getValue(self::$attributes, $name)) !== null) {
            return $attribute;
        } else {
            throw new \yii\web\HttpException(404, "The requested attribute '$name' not found");
        }
    }
}