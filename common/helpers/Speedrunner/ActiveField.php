<?php
 
namespace common\helpers\Speedrunner;
 
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class ActiveField
{
    public function translation($form, $model, $name, $input_type, $field_options = [], $input_options = [])
    {
        foreach (Yii::$app->i18n->getLanguages() as $l) {
            $new_name = "{$name}[{$l['code']}]";
            $new_input_options = ArrayHelper::merge([
                'value' => ArrayHelper::getValue($model->translation_attrs[$name], $l['code']),
            ], $input_options);
            
            $form_groups[] = $form->field($model, $new_name, $field_options)->{$input_type}($new_input_options);
            
            $lang_buttons[] = Html::button(
                ucfirst($l['code']),
                ['class' => 'mb-2 btn btn-sm btn-' . ($l['code'] == Yii::$app->language ? 'primary' : 'outline-primary')]
            );
        }
        
        $result = Html::tag('div', implode(null, $lang_buttons), ['class' => 'btn-group float-right']);
        $result .= implode(null, $form_groups);
        
        return Html::tag('div', $result, ['class' => 'form-groups-wrapper']);
    }
}