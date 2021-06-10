<?php

namespace speedrunner\services;

use Yii;


class FormatterService
{
    public static function asPrice($price, $format = '{price} $')
    {
        return Yii::t('app', $format, [
            'price' => Yii::$app->formatter->asDecimal($price),
        ]);
    }
}
