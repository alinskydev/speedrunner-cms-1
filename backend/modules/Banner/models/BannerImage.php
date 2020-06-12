<?php

namespace backend\modules\Banner\models;

use Yii;
use common\components\framework\ActiveRecord;
use backend\modules\Banner\modelsTranslation\BannerImageTranslation;


class BannerImage extends ActiveRecord
{
    public $translation_table = 'BannerImageTranslation';
    public $translation_attrs = [
        'text_1',
        'text_2',
        'text_3',
        'link',
    ];
    
    public $text_1;
    public $text_2;
    public $text_3;
    public $link;
    
    public static function tableName()
    {
        return 'BannerImage';
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
            'item_id' => Yii::t('app', 'Item ID'),
            'text_1' => Yii::t('app', 'Text 1'),
            'text_2' => Yii::t('app', 'Text 2'),
            'text_3' => Yii::t('app', 'Text 3'),
            'link' => Yii::t('app', 'Link'),
            'image' => Yii::t('app', 'Image'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(BannerImageTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
}
