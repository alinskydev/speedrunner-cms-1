<?php

$model->registerSeoMeta();

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->title];

foreach ($model->blocks as $block) {
    echo $this->render("view/{$block->type->name}", [
        'value' => $block->value,
    ]);
}
