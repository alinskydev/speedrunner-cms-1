<?php

namespace backend\modules\Menu\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class MenuTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'MenuTranslation';
    }
}
