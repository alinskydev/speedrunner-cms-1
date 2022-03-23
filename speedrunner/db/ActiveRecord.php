<?php

namespace speedrunner\db;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use speedrunner\services\ActiveService;

use backend\modules\Seo\services\SeoMetaService;


class ActiveRecord extends \yii\db\ActiveRecord
{
    use \speedrunner\base\traits\ModelRulesTrait;
    
    public $enums = null;
    public $searchModel = null;
    public $service = null;
    
    public $translation_attributes = [];
    
    public function init()
    {
        //        Setting enums
        
        $enums_class_name = str_replace('\models\\', '\enums\\', get_called_class()) . 'Enums';
        
        if ($this->enums === null) {
            $this->enums = class_exists($enums_class_name) ? new $enums_class_name($this) : null;
        }
        
        //        Setting search model
        
        $search_model_class_name = str_replace('\models\\', '\search\\', get_called_class()) . 'Search';
        
        if ($this->searchModel === null) {
            $this->searchModel = class_exists($search_model_class_name) ? new $search_model_class_name($this) : null;
        }
        
        //        Setting service
        
        $service_class_name = str_replace('\models\\', '\services\\', get_called_class()) . 'Service';
        
        if ($this->service === null) {
            $this->service = class_exists($service_class_name) ? new $service_class_name($this) : new ActiveService($this);
        }
        
        return parent::init();
    }
    
    //        Applying API fields
    
    public function fields()
    {
        $class_name = StringHelper::basename(get_called_class());
        
        $module_name = str_replace('backend\modules\\', '', get_called_class());
        $module_name = str_replace("\models\\$class_name", '', $module_name);
        
        $api_class_name = "api\\models\\$module_name\\$class_name";
        
        $fields = class_exists($api_class_name) ? (new $api_class_name())->fields() : parent::fields();
        
        foreach ($fields as $key => $value) {
            if (is_string($value) && isset($this->translation_attributes[$value])) {
                $result[$value] = fn($model) => $this->translation_attributes[$value];
            } else {
                $result[$key] = $value;
            }
        }
        
        return $result ?? [];
    }
    
    //        Setting translations
    
    public function setTranslations()
    {
        foreach ($this->translation_attributes as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }
    
    //        Seo meta registration
    
    public function registerSeoMeta($type = 'page')
    {
        $seo_meta = (new SeoMetaService($this))->getMetaValue();
        
        Yii::$app->view->params['seo_meta'][$type] = [
            'head' => ArrayHelper::getValue($seo_meta, 'head'),
            'body' => [
                'top' => ArrayHelper::getValue($seo_meta, 'body_top'),
                'bottom' => ArrayHelper::getValue($seo_meta, 'body_bottom'),
            ],
        ];
    }
    
    //        Setting query
    
    public static function find()
    {
        $query_class_name = str_replace('\models\\', '\query\\', get_called_class()) . 'Query';
        
        if (class_exists($query_class_name)) {
            return Yii::createObject($query_class_name, [get_called_class()]);
        } else {
            return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
        }
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
        
        if (array_key_exists('created_at', $this->attributes)) {
            $this->created_at = $this->created_at ?? date('Y-m-d H:i:s');
        }
        
        if (array_key_exists('updated_at', $this->attributes)) {
            $this->updated_at = date('Y-m-d H:i:s');
        }
        
        //        HTML purifier
        
        $allowed_chars = [
            '%7B' => '{',
            '%7D' => '}',
            '%3A' => ':',
            '&amp;' => '&',
        ];
        
        foreach ($this->dirtyAttributes as $attribute => $value) {
            if ($value) {
                if (is_array($value)) {
                    array_walk_recursive($value, function(&$v, $k) use ($allowed_chars) {
                        $v = Yii::$app->helpers->html->purify($v, $allowed_chars);
                    });
                    
                    $this->{$attribute} = $value;
                } else {
                    $this->{$attribute} = Yii::$app->helpers->html->purify($value, $allowed_chars);
                }
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
