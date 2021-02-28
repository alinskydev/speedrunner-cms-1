<?php

namespace speedrunner\db;

use Yii;
use yii\db\Expression;


trait ActiveQueryTrait
{
    public $asObject;
    
    public function asObject($value = true)
    {
        $this->asArray = $value;
        $this->asObject = $value;
        
        return $this;
    }
}