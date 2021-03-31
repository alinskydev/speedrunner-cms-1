<?php

namespace backend\modules\Product\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;

use backend\modules\Product\models\ProductVariation;


class ProductService extends ActiveService
{
    public function realPrice()
    {
        return round($this->model->price * (1 - $this->model->discount / 100));
    }
    
    public function assignVariationAttributes(ProductVariation $variation, $with_images = true)
    {
        $this->model->price = $variation->price;
        $this->model->discount = $variation->discount;
        $this->model->quantity = $variation->quantity;
        $this->model->sku = $variation->sku;
        
        if ($with_images) {
            $this->model->images = $variation->images ?: $this->model->images;
        }
    }
}