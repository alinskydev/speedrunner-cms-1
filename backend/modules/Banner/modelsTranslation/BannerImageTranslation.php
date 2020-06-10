<?php

namespace backend\modules\Banner\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class BannerImageTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'BannerImageTranslation';
    }
}
