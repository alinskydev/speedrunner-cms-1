<?php

namespace backend\modules\Staticpage\models;

use Yii;
use common\framework\ActiveRecord;

use backend\modules\Staticpage\services\StaticpageService;


class Staticpage extends ActiveRecord
{
    public $service = true;
    
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
        return $this->hasMany(StaticpageBlock::className(), ['staticpage_id' => 'id'])->orderBy('part_index');
    }
}
