<?php

Yii::$app->sr->seo->registerMeta($model);

foreach ($blocks as $block) {
    echo $this->render('view/' . $block->type->name, [
        'value' => $block->value,
    ]);
}

?>
