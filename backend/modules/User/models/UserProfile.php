<?php

namespace backend\modules\User\models;

use Yii;
use speedrunner\db\ActiveRecord;


class UserProfile extends ActiveRecord
{
    public static function tableName()
    {
        return 'UserProfile';
    }
}
