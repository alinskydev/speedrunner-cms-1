<?php

Yii::setAlias('@root', dirname(dirname(__DIR__)));
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');

switch (YII_ENV) {
    case 'dev':
        error_reporting(E_ALL);
        break;
    case 'prod':
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        break;
}
