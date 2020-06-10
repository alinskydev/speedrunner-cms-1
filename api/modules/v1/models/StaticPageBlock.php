<?php

namespace api\modules\v1\models;

use Yii;


class StaticPageBlock extends \backend\modules\StaticPage\models\StaticPageBlock
{
    public function fields()
    {
        return [
            'name',
            'label',
            'part_name',
            'value' => function ($model) {
                return $model->value;
            },
            'images',
        ];
    }
    
    public function getImages()
    {
        return $this->hasMany(StaticPageBlockImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
}
