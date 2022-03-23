<?php

namespace backend\widgets\crud;

use yii\base\Widget;
use yii\widgets\ActiveForm;


class RelationsWidget extends Widget
{
    public ActiveForm $form;
    public array $relations;
    
    public array $table_options = [];

    public string $name_prefix;
    public array $attributes = [];

    public function run()
    {
        return $this->render('relations', [
            'form' => $this->form,
            'relations' => $this->relations,
            'table_options' => $this->table_options,
            'name_prefix' => $this->name_prefix,
            'attributes' => $this->attributes,
        ]);
    }
}
