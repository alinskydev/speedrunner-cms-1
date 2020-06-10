<?php

namespace backend\modules\StaticPage\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class StaticPageBlockTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'StaticPageBlockTranslation';
    }
}
