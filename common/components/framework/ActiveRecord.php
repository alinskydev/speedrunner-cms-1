<?php

namespace common\components\framework;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\db\Expression;


class ActiveRecord extends \yii\db\ActiveRecord
{
    public function afterFind()
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attributes'] as $key => $d_f_a) {
            foreach ($d_f_a['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['afterFind'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attributes'] as $key => $d_f_a) {
            foreach ($d_f_a['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['beforeSave'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        //        DATETIME
        
        if (array_key_exists('created', $this->attributes)) {
            $this->created = $this->created ?? date('Y-m-d H:i:s');
        }
        
        if (array_key_exists('updated', $this->attributes)) {
            $this->updated = date('Y-m-d H:i:s');
        }
        
        //        HTML PURIFIER
        
        $model_class = StringHelper::basename($this->className());
        
        if (in_array($model_class, ['User', 'UserProfile'])) {
            foreach ($this->attributes as $key => $a) {
                ($a && is_string($a)) ? $this->{$key} = strip_tags($a) : null;
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        ALERTS
        
        if (Yii::$app->id == 'app-backend') {
            $model_class = StringHelper::basename($this->className());
            
            if (!in_array($model_class, ['LogAction', 'LogActionAttr', 'SeoMeta', 'UserNotification'])) {
                Yii::$app->session->setFlash('success', [0 => Yii::t('app', 'Record has been saved')]);
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        //        ALERTS
        
        if (Yii::$app->id == 'app-backend') {
            $model_class = StringHelper::basename($this->className());
            
            if (!in_array($model_class, ['LogAction', 'LogActionAttr', 'SeoMeta', 'UserNotification'])) {
                Yii::$app->session->setFlash('success', [0 => Yii::t('app', 'Record has been deleted')]);
            }
        }
        
        return parent::afterDelete();
    }
    
    public function beforeSearch()
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attributes'] as $key => $d_f_a) {
            foreach ($d_f_a['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['beforeSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
    
    public function afterSearch()
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attributes'] as $key => $d_f_a) {
            foreach ($d_f_a['attributes'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['afterSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
    
    static function itemsList($attr, $type, $q = null, $limit = 20)
    {
        $query = static::find()->limit($limit);
        $model_class = StringHelper::basename($query->modelClass);
        $lang = Yii::$app->language;
        
        switch ($type) {
            case 'self':
                $query->select(["$model_class.id", "$model_class.$attr as text"])
                    ->andFilterWhere(['like', "$model_class.$attr", $q]);
                
                break;
            case 'translation':
                $query->select(["$model_class.id", new Expression("$model_class.$attr->>'$.$lang' as text")])
                    ->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($model_class.$attr, '$.$lang'))"), strtolower($q)]);
                
                break;
        }
        
        return $query;
    }
}
