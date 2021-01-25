<?php

namespace backend\modules\User\models;

use Yii;
use common\framework\ActiveRecord;


class UserProfile extends ActiveRecord
{
    public static function tableName()
    {
        return 'UserProfile';
    }
}
