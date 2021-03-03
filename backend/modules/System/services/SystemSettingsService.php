<?php

namespace backend\modules\System\services;
 
use Yii;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;

use backend\modules\System\models\SystemSettings;


class SystemSettingsService
{
    private static $attributes = null;
    
    public function __construct()
    {
        if (self::$attributes === null) {
            $settings = Yii::$app->db->cache(function ($db) {
                return SystemSettings::find()->asArray()->all();
            }, 0, new TagDependency(['tags' => 'system_settings']));
            
            self::$attributes = ArrayHelper::map($settings, 'name', 'value');
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