<?php

namespace backend\modules\Log\services;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;

use backend\modules\Log\lists\LogActionModelsList;


class LogActionService extends ActiveService
{
    public function attrsColumn($attrs_type, $view_type)
    {
        $result = [];
        $model_class = $this->findAndFill();
        
        $model = ArrayHelper::getValue($model_class, 'model');
        $translation_attrs = ArrayHelper::getValue($model_class, 'attributes.translation', []);
        $boolean_attrs = ArrayHelper::getValue($model_class, 'attributes.boolean', []);
        $enum_attrs = ArrayHelper::getValue($model_class, 'attributes.enum', []);
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
            if (isset($enum_attrs[$a->name]))
                $value = ArrayHelper::getValue($enum_attrs[$a->name], "$value.label");
            
            if (in_array($a->name, $text_attrs) && $view_type == 'short') {
                $value = Yii::t('app', '{length} symbols', ['length' => strlen($value)]);
            }
            
            if (in_array($a->name, $json_attrs)) {
                if ($view_type == 'short') {
                    $value = is_countable($value) ? count($value) : 0;
                } else {
                    $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                    $value = str_replace("},\n", "\n<hr>", $value);
                    $value = str_replace(['{', '}', '[', ']', '"'], null, $value);
                }
            }
            
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
            
            $result[] = Html::tag('b', $model->getAttributeLabel($a->name)) . ': ' . nl2br($value);
        }
        
        return implode($view_type == 'short' ? '<br>' : '<hr>', $result);
    }
    
    public function findAndFill()
    {
        if ($model = ArrayHelper::getValue((new LogActionModelsList())::$data, $this->model->model_class)) {
            if ($index_url = ArrayHelper::getValue($model, 'index_url')) {
                $model['index_url'] = [$index_url[0], $index_url[1] => $this->model['model_id']];
            }
            
            return $model;
        } else {
            throw new \yii\web\HttpException(404, "The requested model '{$this->model->model_class}' not found");
        }
    }
}
