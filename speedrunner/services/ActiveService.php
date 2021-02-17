<?php

namespace speedrunner\services;

use Yii;
use speedrunner\db\ActiveRecord;


class ActiveService
{
    protected $model;
    
    public function __construct(ActiveRecord $model)
    {
        $this->model = $model;
    }
}
