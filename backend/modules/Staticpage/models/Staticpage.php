<?php

namespace backend\modules\Staticpage\models;

use Yii;
use speedrunner\db\ActiveRecord;


class Staticpage extends ActiveRecord
{
    public $service = false;
    
    public static function tableName()
    {
        return '{{%staticpage}}';
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => [
                'class' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            ],
            'cache' => [
                'class' => \speedrunner\behaviors\CacheBehavior::className(),
                'tags' => ['staticpages'],
            ],
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(StaticpageBlock::className(), ['staticpage_id' => 'id'])->orderBy('part_index');
    }
}
