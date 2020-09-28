<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;
use backend\modules\User\models\User;


class BlogRate extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogRate';
    }
    
    public function rules()
    {
        return [
            [['blog_id', 'mark'], 'required'],
            [['mark'], 'integer', 'min' => 1, 'max' => 10],
            
            [['blog_id'], 'exist', 'targetClass' => Blog::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'blog_id' => Yii::t('app', 'Blog'),
            'user_id' => Yii::t('app', 'User'),
            'mark' => Yii::t('app', 'Mark'),
            'created' => Yii::t('app', 'Created'),
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
