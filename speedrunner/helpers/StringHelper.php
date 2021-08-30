<?php

namespace speedrunner\helpers;

use Yii;


class StringHelper
{
    public static function randomize(int $length = 16)
    {
        return md5(uniqid() . Yii::$app->security->generateRandomString($length));
    }
}
