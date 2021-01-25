<?php

namespace backend\modules\User\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class UserNotification extends ActiveRecord
{
    public static function tableName()
    {
        return 'UserNotification';
    }
    
    public function rules()
    {
        return [
            [['user_id', 'action_type', 'action_id', 'params'], 'required'],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
