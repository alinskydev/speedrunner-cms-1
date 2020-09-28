<?php

namespace backend\modules\Staticpage\models;

use Yii;
use common\components\framework\ActiveRecord;


class Staticpage extends ActiveRecord
{
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'Staticpage';
    }
    
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
        return $this->hasMany(StaticpageBlock::className(), ['item_id' => 'id'])->orderBy('part_index');
    }
}
