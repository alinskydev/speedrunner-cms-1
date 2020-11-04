<?php

use yii\helpers\ArrayHelper;

$theme = ArrayHelper::getValue(Yii::$app->user->identity, 'design_theme', 'nav_full');

echo $this->render("@backend/views/layouts/themes/$theme", ['content' => $content]);
echo $this->render('@backend/views/layouts/design/style');

?>