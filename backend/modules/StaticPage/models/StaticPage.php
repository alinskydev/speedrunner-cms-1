<?php

namespace backend\modules\StaticPage\models;

use Yii;
use common\components\framework\ActiveRecord;


class StaticPage extends ActiveRecord
{
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'StaticPage';
    }
    
    public function getBlocks()
    {
        return $this->hasMany(StaticPageBlock::className(), ['item_id' => 'id'])->orderBy('part_index');
    }
}
