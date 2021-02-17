<?php

namespace speedrunner\db;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\HtmlPurifier;


class ActiveRecord extends \yii\db\ActiveRecord
{
    const HTMLPURIFY_EXCLUDE_CLASSES = [];
    
    public $service = null;
    
    public function init()
    {
        //        Setting service
        
        $service_class_name = str_replace('\models\\', '\services\\', get_called_class()) . 'Service';
        
        if ($this->service === null) {
            $this->service = class_exists($service_class_name) ? new $service_class_name($this) : null;
        }
        
        return parent::init();
    }
    
    public function fields()
    {
        //        API fields
        
        $class_name = StringHelper::basename(get_called_class());
        
        $module_name = str_replace('backend\modules\\', null, get_called_class());
        $module_name = str_replace("\models\\$class_name", null, $module_name);
        
        $api_module_name = 'v1';
        $api_class_name = "api\modules\\$api_module_name\models\\$module_name\\$class_name";
        
        return class_exists($api_class_name) ? (new $api_class_name())->fields() : parent::fields();
    }
    
    public static function find()
    {
        //        Setting query
        
        $query_class_name = str_replace('\models\\', '\query\\', get_called_class()) . 'Query';
        return class_exists($query_class_name) ? new $query_class_name(get_called_class()) : new ActiveQuery(get_called_class());
    }
    
    public function afterFind()
    {
        //        Changing dates format
        
        foreach (Yii::$app->params['date_formats'] as $key => $d_f) {
            foreach ($d_f['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f['formats']['afterFind'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        Changing dates format
        
        foreach (Yii::$app->params['date_formats'] as $key => $d_f) {
            foreach ($d_f['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f['formats']['beforeSave'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        //        Setting values to default attributes
        
        if (array_key_exists('created', $this->attributes)) {
            $this->created = $this->created ?? date('Y-m-d H:i:s');
        }
        
        if (array_key_exists('updated', $this->attributes)) {
            $this->updated = date('Y-m-d H:i:s');
        }
        
        //        HTML purifier
        
        $class_name = StringHelper::basename(get_called_class());
        
        if (!in_array($class_name, static::HTMLPURIFY_EXCLUDE_CLASSES)) {
            foreach ($this->dirtyAttributes as $key => $a) {
                ($a && is_string($a)) ? $this->{$key} = HtmlPurifier::process($a) : null;
//                ($a && is_string($a)) ? $this->{$key} = htmlspecialchars($a, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : null;
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function beforeSearch()
    {
        //        Changing dates format
        
        foreach (Yii::$app->params['date_formats'] as $key => $d_f) {
            foreach ($d_f['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f['formats']['beforeSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
    
    public function afterSearch()
    {
        //        Changing dates format
        
        foreach (Yii::$app->params['date_formats'] as $key => $d_f) {
            foreach ($d_f['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f['formats']['afterSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
}
