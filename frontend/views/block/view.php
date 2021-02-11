<?php

(new \backend\modules\Seo\services\SeoMetaService($model))->register();

$this->params['breadcrumbs'][] = ['label' => $this->title];

foreach ($model->blocks as $block) {
    echo $this->render("view/{$block->type->name}", [
        'value' => $block->value,
    ]);
}
