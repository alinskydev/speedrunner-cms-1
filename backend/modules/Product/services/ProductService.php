<?php

namespace backend\modules\Product\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;


class ProductService extends ActiveService
{
    public function realPrice()
    {
        return round($this->model->price * (1 - $this->model->discount / 100));
    }
}