<?php

namespace backend\modules\StaticPage\models;

use Yii;
use common\components\framework\ActiveRecord;


class StaticPageBlockImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'StaticPageBlockImage';
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->file->delete($this, 'image');
        
        return parent::afterDelete();
    }
}
