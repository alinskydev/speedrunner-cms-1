<?php

namespace backend\modules\Staticpage\models;

use Yii;
use speedrunner\db\ActiveRecord;

use backend\modules\Staticpage\services\StaticpageService;


class Staticpage extends ActiveRecord
{
    public $service = false;
    
    public static function tableName()
    {
        return 'Staticpage';
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => [
                'class' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            ],
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(StaticpageBlock::className(), ['staticpage_id' => 'id'])->orderBy('part_index');
    }
}
