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
    
    public function afterFind()
    {
        if ($this->has_seo_meta) {
            $this->attachBehavior('seo_meta', \backend\modules\Seo\behaviors\SeoMetaBehavior::className());
        }
        
        return parent::afterFind();
    }
}
