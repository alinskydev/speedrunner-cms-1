<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;
use backend\modules\User\models\User;


class BlogRate extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%blog_rate}}';
    }
    
    public function prepareRules()
    {
        return [
            'mark' => [
                ['required'],
                ['integer', 'min' => 1, 'max' => 10],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'blog_id' => Yii::t('app', 'Blog'),
            'user_id' => Yii::t('app', 'User'),
            'mark' => Yii::t('app', 'Mark'),
            'created_at' => Yii::t('app', 'Created at'),
        ];
    }
    
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
