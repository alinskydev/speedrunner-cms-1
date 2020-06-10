<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;


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
            [['name'], 'string', 'max' => 255],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
    
    public function afterDelete()
    {
        BlogTagRef::deleteAll(['tag_id' => $this->id]);
        
        return parent::afterDelete();
    }
}
