<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;


class BlogImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogImage';
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->file->delete($this, 'image');
        
        return parent::afterDelete();
    }
}
