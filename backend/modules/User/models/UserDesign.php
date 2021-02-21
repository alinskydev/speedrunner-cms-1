<?php

namespace backend\modules\User\models;

use Yii;
use speedrunner\db\ActiveRecord;


class UserDesign extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_design}}';
    }
}
