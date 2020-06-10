<?php

namespace backend\modules\Blog\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class BlogTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogTranslation';
    }
}
