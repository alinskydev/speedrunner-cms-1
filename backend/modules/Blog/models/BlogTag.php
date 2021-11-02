<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;


class BlogTag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%blog_tag}}';
    }
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['required'],
                ['unique'],
                ['string', 'max' => 100],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }
}
