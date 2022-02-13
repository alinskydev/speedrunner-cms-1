<?php

namespace speedrunner\helpers;

use Yii;


class FormatterHelper
{
    public static function asPrice($price, $format = '{price} $')
    {
        return Yii::t('app', $format, [
            'price' => Yii::$app->formatter->asDecimal($price),
        ]);
    }

    public static function asDate($date, $format = 'd.m.Y')
    {
        return date($format, strtotime($date));
    }
}
