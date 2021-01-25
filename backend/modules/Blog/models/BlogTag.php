<?php

namespace backend\modules\Blog\models;

use Yii;
use common\framework\ActiveRecord;


class BlogTag extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogTag';
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
}
