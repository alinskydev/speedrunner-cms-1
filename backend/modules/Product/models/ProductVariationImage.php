<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;


class ProductVariationImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductVariationImage';
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->file->delete($this, 'image');
        
        return parent::afterDelete();
    }
}
