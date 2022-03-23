<?php

namespace speedrunner\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class TranslationActiveField extends \yii\bootstrap\ActiveField
{
    public $real_model = null;
    
    private $langs;
    private $render_data = [];
    
    public function init()
    {
        $this->model = $this->real_model ?? $this->model;
        $this->langs = Yii::$app->urlManager->languages;
        return parent::init();
    }
    
    public function textInput($options = []) { return $this->prerender(__FUNCTION__, $options); }
    public function textarea($options = []) { return $this->prerender(__FUNCTION__, $options); }
    public function fileInput($options = []) { return $this->prerender(__FUNCTION__, $options); }
    public function widget($class, $config = []) { return $this->prerender(__FUNCTION__, ['class' => $class, 'config' => $config]); }
    
    public function prerender($method, $options = [])
    {
        $translations = $this->model->translation_attributes[$this->attribute] ?? [];
        $translations = array_map(fn($value) => $translations[array_search($value, $this->langs)] ?? null, $this->langs);
        
        $this->model->{$this->attribute} = is_array($this->model->{$this->attribute}) ? $this->model->{$this->attribute} : $translations;
        $old_attribute = $this->attribute;
        
        if (isset($options['name'])) $name = $options['name'];
        
        foreach ($translations as $lang => $translation) {
            if (isset($options['name'])) $options['name'] = $name . "[$lang]";
            
            $this->attribute = $old_attribute . "[$lang]";
            $method == 'widget' ? parent::{$method}($options['class'], $options['config']) : parent::{$method}($options);
            $this->render_data[$lang] = parent::render();
            $this->parts = [];
        }
        
        return $this;
    }
    
    public function render($content = null)
    {
        $html[] = Html::beginTag('div', ['class' => 'my-3']);
        $html[] = Html::beginTag('ul', ['class' => 'nav nav-tabs nav-input-tabs']);
        
        foreach ($this->render_data as $lang => $r_d) {
            $id = Html::getInputId($this->model, "{$this->attribute}_{$lang}_tab");
            
            $html[] = Html::beginTag('li', ['class' => 'nav-item']);
            $html[] = Html::a(
                Html::img(Yii::$app->helpers->image->thumb(ArrayHelper::getValue($this->langs, "$lang.image"), [30, 20], 'crop')),
                "#$id",
                [
                    'class' => 'nav-link ' . ($lang == Yii::$app->language ? 'active' : null),
                    'data-toggle' => 'tab',
                ]
            );
            
            $html[] = Html::endTag('li');
        }
        
        $html[] = Html::endTag('ul');
        $html[] = Html::beginTag('div', ['class' => 'tab-content p-3 border border-top-0']);
        
        foreach ($this->render_data as $lang => $r_d) {
            $id = Html::getInputId($this->model, "{$this->attribute}_{$lang}_tab");
            
            $html[] = Html::tag('div', $r_d, [
                'id' => $id,
                'class' => 'tab-pane ' . ($lang == Yii::$app->language ? 'active' : 'fade'),
            ]);
        }
        
        $html[] = Html::endTag('div');
        $html[] = Html::endTag('div');
        
        return implode('', $html);
    }
}
