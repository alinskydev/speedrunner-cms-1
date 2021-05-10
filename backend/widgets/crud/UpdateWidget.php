<?php

namespace backend\widgets\crud;

use yii\base\Widget;
use yii\base\Model;


class UpdateWidget extends Widget
{
    public Model $model;
    public ?Model $seo_meta_model = null;
    public bool $has_seo_meta = false;
    
    public array $form_options = [];
    public array $save_buttons = ['save_update', 'save'];
    
    public array $tabs = [];
    
    public function run()
    {
        return $this->render('update', [
            'model' => $this->model,
            'has_seo_meta' => $this->has_seo_meta,
            'seo_meta_model' => $this->seo_meta_model,
            
            'form_options' => $this->form_options,
            'save_buttons' => $this->save_buttons,
            
            'tabs' => $this->tabs,
        ]);
    }
}
