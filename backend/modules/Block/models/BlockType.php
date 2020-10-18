<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;


class BlockType extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlockType';
    }
    
    public function rules()
    {
        return [
            [['label', 'image'], 'required'],
            [['label', 'image'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'type' => Yii::t('app', 'Type'),
            'has_translation' => Yii::t('app', 'Has translation'),
            'image' => Yii::t('app', 'Image'),
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['type_id' => 'id']);
    }
}
