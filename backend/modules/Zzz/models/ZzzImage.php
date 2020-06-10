<?php

namespace backend\modules\Zzz\models;

use Yii;
use common\components\framework\ActiveRecord;


class ZzzImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'ZzzImage';
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->file->delete($this, 'image');
        
        return parent::afterDelete();
    }
}
