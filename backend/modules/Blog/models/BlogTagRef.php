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
}
