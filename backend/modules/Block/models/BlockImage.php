<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;
use backend\modules\Block\modelsTranslation\BlockImageTranslation;


class BlockImage extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlockImage';
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->file->delete($this, 'image');
        
        return parent::afterDelete();
    }
}
