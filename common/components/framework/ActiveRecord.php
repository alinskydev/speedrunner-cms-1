<?php

namespace common\components\framework;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\HtmlPurifier;
use yii\db\Expression;
use yii\db\JsonExpression;


class ActiveRecord extends \yii\db\ActiveRecord
{
    public function afterFind()
    {
        //        TRANSLATIONS
        
        if (isset($this->translation_attrs)) {
            foreach ($this->translation_attrs as $a) {
                $this->{$a} = ArrayHelper::getValue($this->{$a}, Yii::$app->language);
            }
        }
        
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['afterFind'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        TRANSLATIONS
        
        if (isset($this->translation_attrs)) {
            foreach ($this->translation_attrs as $a) {
                if ($json = ArrayHelper::getValue($this->oldAttributes, $a)) {
                    $json[Yii::$app->language] = $this->{$a};
                } else {
                    $langs = Yii::$app->i18n->getLanguages(true);
                    
                    foreach ($langs as $l) {
                        $json[$l['code']] = $this->{$a};
                    } 
                }
                
                $this->{$a} = new JsonExpression($json);
            }
        }
        
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['beforeSave'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        //        DATETIME
        
        if (array_key_exists('created', $this->attributes)) {
            $this->created = $this->created ?: date('Y-m-d H:i:s');
        }
        
        if (array_key_exists('updated', $this->attributes)) {
            $this->updated = date('Y-m-d H:i:s');
        }
        
        //        HTML PURIFIER
        
        $class_name = basename($this->className());
        
        if (in_array($class_name, ['User', 'UserProfile'])) {
            foreach ($this->attributes as $key => $a) {
                ($a && is_string($a)) ? $this->{$key} = strip_tags($a) : null;
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        SEO META
        
        if (isset($this->seo_meta) && $value = Yii::$app->request->post('SeoMeta')) {
            Yii::$app->sr->seo->saveMeta($this, $value);
        }
        
        //        ALERTS
        
        if (Yii::$app->id == 'app-backend') {
            $class_name = basename($this->className());
            
            if (!in_array($class_name, ['LogAction', 'LogActionAttr'])) {
                if (!Yii::$app->session->hasFlash('success')) {
                    Yii::$app->session->addFlash('success', Yii::t('app', 'Record has been saved'), false);
                }
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        //        SEO META
        
        if (isset($this->seo_meta)) {
            Yii::$app->sr->seo->deleteMeta($this);
        }
        
        //        ALERTS
        
        if (Yii::$app->id == 'app-backend') {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Record has been deleted'));
        }
        
        return parent::afterDelete();
    }
    
    public function beforeSearch()
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['beforeSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
    
    public function afterSearch()
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (array_key_exists($a, $this->attributes)) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['afterSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
    
    static function itemsList($attr, $type, $q = null, $limit = 20)
    {
        $query = static::find()->limit($limit);
        $lang = Yii::$app->language;
        
        switch ($type) {
            case 'self':
                $query->select(['id', "$attr as text"])
                    ->andFilterWhere(['like', $attr, $q]);
                
                break;
            case 'translation':
                $query->select(['id', new Expression("$attr->>'$.$lang' as text")])
                    ->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($attr, '$.$lang'))"), strtolower($q)]);
                
                break;
        }
        
        return $query;
    }
}
