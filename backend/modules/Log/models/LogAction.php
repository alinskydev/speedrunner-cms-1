<?php

namespace backend\modules\Log\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

use backend\modules\Log\helpers\LogActionHelper;
use backend\modules\User\models\User;


class LogAction extends ActiveRecord
{
    public $helper;
    
    public function __construct()
    {
        $this->helper = new LogActionHelper;
    }
    
    public static function tableName()
    {
        return 'LogAction';
    }

    public function rules()
    {
        return [
            [['type', 'model_class'], 'required'],
            [['type'], 'in', 'range' => array_keys($this->types())],
            [['model_class'], 'in', 'range' => array_keys($this->helper->modelClasses())],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'user_id' => Yii::t('app', 'User'),
            'type' => Yii::t('app', 'Type'),
            'model_class' => Yii::t('app', 'Action'),
            'model_id' => Yii::t('app', 'Action'),
            'created' => Yii::t('app', 'Created'),
            'attrs_old' => Yii::t('app', 'Old value'),
            'attrs_new' => Yii::t('app', 'New value'),
        ];
    }
    
    static function types()
    {
        return [
            'created' => [
                'label' => Yii::t('app', 'Created'),
            ],
            'updated' => [
                'label' => Yii::t('app', 'Updated'),
            ],
            'deleted' => [
                'label' => Yii::t('app', 'Deleted'),
            ],
        ];
    }
    
    public function attrsColumn($attrs_type, $view_type)
    {
        $result = [];
        $model = ArrayHelper::getValue($this->helper->modelClasses(), "$this->model_class.model");
        $translation_attrs = ArrayHelper::getValue($this->helper->modelClasses(), "$this->model_class.attributes.translation", []);
        $boolean_attrs = ArrayHelper::getValue($this->helper->modelClasses(), "$this->model_class.attributes.boolean", []);
        $select_attrs = ArrayHelper::getValue($this->helper->modelClasses(), "$this->model_class.attributes.select", []);
        $text_attrs = ArrayHelper::getValue($this->helper->modelClasses(), "$this->model_class.attributes.text", []);
        $json_attrs = ArrayHelper::getValue($this->helper->modelClasses(), "$this->model_class.attributes.json", []);
        
        foreach (Yii::$app->params['date_format_attributes'] as $d_f_a) {
            foreach ($d_f_a['attributes'] as $d_a) {
                $date_attributes[$d_a] = $d_f_a['formats']['afterFind'];
            }
        }
        
        foreach ($this->attrs as $a) {
            if (!$a->name) { continue; };
            if ($attrs_type == 'old' && $this->type == 'created') { continue; };
            if ($attrs_type == 'new' && $this->type == 'deleted') { continue; };
            
            $value = $a->{"value_$attrs_type"};
            
            if (isset($date_attributes[$a->name]))
                $value = date($date_attributes[$a->name], strtotime($value));
            if (in_array($a->name, $translation_attrs))
                $value = ArrayHelper::getValue($value, Yii::$app->language);
            if (in_array($a->name, $boolean_attrs))
                $value = Yii::$app->formatter->asBoolean($value);
            if (isset($select_attrs[$a->name]))
                $value = ArrayHelper::getValue($model->{$select_attrs[$a->name]}(), "$value.label");
            
            if (in_array($a->name, $text_attrs) && $view_type == 'short') {
                $value = Yii::t('app', '{length} symbols', ['length' => strlen($value)]);
            }
            
            if (in_array($a->name, $json_attrs)) {
                if ($view_type == 'short') {
                    $value = count($value);
                } else {
                    $value = str_replace(['{', '}', '"'], null, json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                }
            }
            
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            
            $result[] = Html::tag('b', $model->getAttributeLabel($a->name)) . ': ' . nl2br($value);
        }
        
        return implode($view_type == 'short' ? '<br>' : '<hr>', $result);
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getAttrs()
    {
        return $this->hasMany(LogActionAttr::className(), ['action_id' => 'id']);
    }
}
