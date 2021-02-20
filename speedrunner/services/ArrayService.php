<?php

namespace speedrunner\services;

use Yii;


class ArrayService
{
    public static function buildFullPath($data, $attr, $children_attr = 'children', $parent_value = null, $separator = '/')
    {
        foreach ($data as &$d) {
            $d[$attr] = $parent_value ? $parent_value . $separator . $d[$attr] : $d[$attr];
            
            if ($d[$children_attr]) {
                $d[$children_attr] = self::buildFullPath($d[$children_attr], $attr, $children_attr, $d[$attr], $separator);
            }
        }
        
        return $data;
    }
}
