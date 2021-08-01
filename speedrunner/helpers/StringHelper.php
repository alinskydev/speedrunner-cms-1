<?php

namespace speedrunner\helpers;

use Yii;


class StringHelper
{
    public static function randomize(int $length = 16)
    {
        return md5(uniqid() . Yii::$app->security->generateRandomString($length));
    }
    
    public static function buildFullPath(array $array, $attr, $children_attr = 'children', $parent_value = null, $separator = '/')
    {
        foreach ($array as &$arr) {
            $arr[$attr] = $parent_value ? $parent_value . $separator . $arr[$attr] : $arr[$attr];
            
            if ($arr[$children_attr]) {
                $arr[$children_attr] = self::buildFullPath($arr[$children_attr], $attr, $children_attr, $arr[$attr], $separator);
            }
        }
        
        return $array;
    }
}
