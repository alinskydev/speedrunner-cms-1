<?php

namespace api\modules\v1\models;

use Yii;


class Banner extends \backend\modules\Banner\models\Banner
{
    public function fields()
    {
        return [
            'id',
            'location',
            'images',
        ];
    }
    
    public function getImages()
    {
        return $this->hasMany(BannerImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
}
