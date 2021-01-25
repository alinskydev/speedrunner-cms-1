<?php

namespace backend\modules\Log\services;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Log\models\LogAction;
use backend\modules\Log\lists\LogActionModelsList;


class LogActionService
{
    private $model;
    
    public function __construct(LogAction $model)
    {
        $this->model = $model;
    }
    
    public function attrsColumn($attrs_type, $view_type)
    {
        $result = [];
        $model_class = (new LogActionModelsList())->findAndFill($this->model);
        
        $model = ArrayHelper::getValue($model_class, 'model');
        $translation_attrs = ArrayHelper::getValue($model_class, 'attributes.translation', []);
        $boolean_attrs = ArrayHelper::getValue($model_class, 'attributes.boolean', []);
        $select_attrs = ArrayHelper::getValue($model_class, 'attributes.select', []);
        $text_attrs = ArrayHelper::getValue($model_class, 'attributes.text', []);
        $json_attrs = ArrayHelper::getValue($model_class, 'attributes.json', []);
        
        foreach (Yii::$app->params['date_formats'] as $d_f) {
            foreach ($d_f['attributes'] as $a) {
                $date_attributes[$a] = $d_f['formats']['afterFind'];
            }
        }
        
        foreach ($this->model->attrs as $a) {
            if (!$a->name) { continue; };
            if ($attrs_type == 'old' && $this->model->type == 'created') { continue; };
            if ($attrs_type == 'new' && $this->model->type == 'deleted') { continue; };
            
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
}
