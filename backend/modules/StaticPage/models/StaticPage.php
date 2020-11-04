<?php

namespace backend\modules\Staticpage\models;

use Yii;
use common\components\framework\ActiveRecord;


class Staticpage extends ActiveRecord
{
    use \api\modules\v1\models\Staticpage;
    
    public static function tableName()
    {
        return 'Staticpage';
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => [
                'class' => \common\behaviors\SeoMetaBehavior::className(),
            ],
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(StaticpageBlock::className(), ['item_id' => 'id'])->orderBy('part_index');
    }
}
