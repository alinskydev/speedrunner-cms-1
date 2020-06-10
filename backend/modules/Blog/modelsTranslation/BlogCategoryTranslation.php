<?php

namespace backend\modules\Blog\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class BlogCategoryTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlogCategoryTranslation';
    }
}
