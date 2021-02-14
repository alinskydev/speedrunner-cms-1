<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;
use backend\modules\User\models\User;


class BlogComment extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogComment';
    }
    
    public function rules()
    {
        return [
            [['blog_id', 'text'], 'required'],
            [['status'], 'in', 'range' => array_keys($this->statuses())],
            [['text'], 'string', 'max' => 1000],
            
            [['blog_id'], 'exist', 'targetClass' => Blog::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'blog_id' => Yii::t('app', 'Blog'),
            'user_id' => Yii::t('app', 'User'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
    
    public static function statuses()
    {
        return [
            'new' => [
                'label' => Yii::t('app', 'New'),
            ],
            'published' => [
                'label' => Yii::t('app', 'Published'),
            ],
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
    
    public function beforeSave($insert)
    {
        $this->text = strip_tags($this->text);
        return parent::beforeSave($insert);
    }
}
