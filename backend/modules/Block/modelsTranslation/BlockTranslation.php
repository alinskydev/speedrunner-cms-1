<?php

namespace backend\modules\Block\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class BlockTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'BlockTranslation';
    }
}
