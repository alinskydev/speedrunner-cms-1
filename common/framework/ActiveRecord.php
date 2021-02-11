<?php

namespace common\framework;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\HtmlPurifier;


class ActiveRecord extends \yii\db\ActiveRecord
{
    const HTMLPURIFY_EXCLUDE_CLASSES = [];
    
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }
    
    public function afterFind()
    {
        //        Changing date formats
        
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
        //        Changing date formats
        
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
        
        $model_class = StringHelper::basename($this->className());
        
        if (!in_array($model_class, static::HTMLPURIFY_EXCLUDE_CLASSES)) {
            foreach ($this->attributes as $key => $a) {
                ($a && is_string($a)) ? $this->{$key} = HtmlPurifier::process($a) : null;
//                ($a && is_string($a)) ? $this->{$key} = htmlspecialchars($a, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : null;
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function beforeSearch()
    {
        //        Changing date formats
        
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
        //        Changing date formats
        
        foreach (Yii::$app->params['date_formats'] as $key => $d_f) {
            foreach ($d_f['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f['formats']['afterSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
}
