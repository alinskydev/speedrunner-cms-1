<?php

namespace api\modules\v1\models;

use Yii;


class StaticPage extends \backend\modules\StaticPage\models\StaticPage
{
    public function fields()
    {
        return [
            'id',
            'location',
            'blocks',
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(StaticPageBlock::className(), ['item_id' => 'id']);
    }
}
