<?php

namespace backend\modules\Blog\models;

use Yii;
use common\components\framework\ActiveRecord;


class BlogTagRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogTagRef';
    }
    
    public function rules()
    {
        return [
            [['blog_id', 'tag_id'], 'required'],
            [['blog_id', 'tag_id'], 'integer'],
            [['lang'], 'string', 'max' => 20],
        ];
    }
}
