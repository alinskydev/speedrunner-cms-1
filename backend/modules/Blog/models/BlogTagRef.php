<?php

namespace backend\modules\Blog\models;

use Yii;
use speedrunner\db\ActiveRecord;


class BlogTagRef extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogTagRef';
    }
}
