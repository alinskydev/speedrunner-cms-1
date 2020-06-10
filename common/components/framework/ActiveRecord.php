<?php

namespace common\components\framework;

use Yii;
use yii\helpers\StringHelper;
use yii\helpers\HtmlPurifier;


class ActiveRecord extends \yii\db\ActiveRecord
{
    public function afterFind()
    {
        //        TRANSLATIONS
        
        if (isset($this->translation_attrs) && isset($this->translation)) {
            foreach ($this->translation_attrs as $a) {
                $this->{$a} = $this->translation->{$a};
            }
        }
        
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (isset($this->attributes[$a])) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['afterFind'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        DATETIME
        
        if (array_key_exists('created', $this->attributes)) {
            $this->created = $this->created ?: date('Y-m-d H:i:s');
        }
        
        if (array_key_exists('updated', $this->attributes)) {
            $this->updated = date('Y-m-d H:i:s');
        }
        
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (isset($this->attributes[$a])) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['beforeSave'], strtotime($this->{$a})) : null;
                }
            }
        }
        
        //        HTML PURIFIER
        
        $class_name = StringHelper::basename($this->className());
        
        if (in_array($class_name, ['User', 'UserProfile'])) {
            foreach ($this->attributes as $key => $a) {
                ($a && is_string($a)) ? $this->{$key} = strip_tags($a) : null;
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        TRANSLATIONS
        
        if (isset($this->translation_attrs)) {
            Yii::$app->sr->translation->set($this, $insert);
        }
        
        //        SEO META
        
        if (isset($this->seo_meta) && $value = Yii::$app->request->post('SeoMeta')) {
            Yii::$app->sr->seo->saveMeta($this, $value);
        }
        
        //        ALERTS
        
        if (Yii::$app->id == 'app-backend') {
            $msg = $insert ? 'Record has been created' : 'Record has been updated';
            Yii::$app->session->setFlash('success', Yii::t('app', $msg));
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
            Yii::$app->session->setFlash('success', Yii::t('app', 'Record has been deleted'));
        }
        
        return parent::afterDelete();
    }
    
    public function beforeSearch()
    {
        //        DATETIME FORMAT
        
        foreach (Yii::$app->params['date_format_attrs'] as $key => $d_f_a) {
            foreach ($d_f_a['attrs'] as $a) {
                if (isset($this->attributes[$a])) {
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
                if (isset($this->attributes[$a])) {
                    $this->{$a} = $this->{$a} ? date($d_f_a['formats']['afterSearch'], strtotime($this->{$a})) : null;
                }
            }
        }
    }
    
    static function getItemsList()
    {
        $model = new static;
        
        if (isset($model->translation_attrs)) {
            return self::find()->with(['translation'])->indexBy('id')->asArray()->all();
        } else {
            return self::find()->indexBy('id')->asArray()->all();
        }
    }
    
    static function getSelectionList($q, $attr, $condition = [])
    {
        $model = new static;
        
        if (isset($model->translation_attrs)) {
            return self::find()
                ->alias('self')
                ->select(['self.id', 'translation.'.$attr.' as text'])
                ->joinWith(['translation as translation'])
                ->where(['like', 'translation.'.$attr, $q])
                ->andWhere($condition)
                ->limit(10)->asArray()->all();
        } else {
            return self::find()
                ->select(['id', $attr.' as text'])
                ->where(['like', $attr, $q])
                ->andWhere($condition)
                ->limit(10)->asArray()->all();
        }
    }
}
