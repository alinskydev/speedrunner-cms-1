<?php

namespace backend\modules\Block\models;

use Yii;
use speedrunner\db\ActiveRecord;


class BlockType extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%block_type}}';
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
            'input_type' => Yii::t('app', 'Input type'),
            'image' => Yii::t('app', 'Image'),
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['type_id' => 'id']);
    }
}
