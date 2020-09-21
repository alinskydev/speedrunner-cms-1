<?php

namespace backend\modules\Banner\models;

use Yii;
use common\components\framework\ActiveRecord;


class BannerGroup extends ActiveRecord
{
    public $translation_attrs = [
        'text_1',
        'text_2',
        'text_3',
        'link',
    ];
    
    public static function tableName()
    {
        return 'BannerGroup';
    }
    
    public function rules()
    {
        return [
            [['image'], 'required'],
            [['text_1', 'text_2', 'text_3', 'link'], 'string', 'max' => 1000],
            [['image'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'item_id' => Yii::t('app', 'Banner'),
            'text_1' => Yii::t('app', 'Text 1'),
            'text_2' => Yii::t('app', 'Text 2'),
            'text_3' => Yii::t('app', 'Text 3'),
            'link' => Yii::t('app', 'Link'),
            'image' => Yii::t('app', 'Image'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
}
