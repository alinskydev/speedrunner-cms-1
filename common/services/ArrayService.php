<?php

namespace common\services;

use Yii;
use common\framework\ActiveRecord;
use yii\db\Expression;


class ArrayService
{
    private $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function buildFullPath($attr, $children_attr = 'children', $parent_value = null, $separator = '/')
    {
        return static::buildFullPathRecursive($this->data, $attr, $children_attr, $parent_value, $separator);
    }
    
    private static function buildFullPathRecursive($data, $attr, $children_attr, $parent_value, $separator)
    {
        foreach ($data as &$d) {
            $d[$attr] = $parent_value ? $parent_value . $separator . $d[$attr] : $d[$attr];
            
            if ($d[$children_attr]) {
                $d[$children_attr] = static::buildFullPathRecursive($d[$children_attr], $attr, $children_attr, $d[$attr], $separator);
            }
        }
        
        return $data;
    }
}
