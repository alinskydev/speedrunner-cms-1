<?php

Yii::$app->sr->seo->registerMeta($model);
$this->params['breadcrumbs'][] = ['label' => $this->title];

foreach ($blocks as $block) {
    echo $this->render('view/' . $block->type->name, [
        'value' => $block->value,
    ]);
}

?>
