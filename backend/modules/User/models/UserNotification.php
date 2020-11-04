<?php

namespace backend\modules\User\models;

use Yii;
use common\components\framework\ActiveRecord;
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
    
    public function actionType()
    {
        switch ($this->action_type) {
            case 'order_created':
                return [
                    'label' => Yii::t('app_notification', 'You have new order'),
                    'url' => ['/order/order/index', 'OrderSearch[id]' => $this->action_id],
                ];
            default:
                return null;
        }
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
