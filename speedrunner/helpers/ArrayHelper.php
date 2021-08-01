<?php

namespace speedrunner\helpers;

use Yii;


class ArrayHelper
{
    public static function asObjects(array $array)
    {
        return json_decode(json_encode($array, JSON_UNESCAPED_UNICODE), false);
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
    
    public static function leaves(array $array, $separator = '/', $parent_value = null, $result = [])
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = self::leaves($value, $separator, $parent_value . $key . $separator, $result);
            } else {
                $result[] = $separator ? $parent_value . $value : $value;
            }
        }
        
        return $result;
    }
}
