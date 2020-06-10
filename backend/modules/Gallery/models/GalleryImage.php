<?php

namespace backend\modules\Gallery\models;

use Yii;
use common\components\framework\ActiveRecord;


class GalleryImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'GalleryImage';
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->file->delete($this, 'image');
        
        return parent::afterDelete();
    }
}
