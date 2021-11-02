<?php

namespace frontend\forms;

use Yii;
use speedrunner\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;
use backend\modules\User\models\User;


class OrderForm extends Model
{
    private $user;
    public $order;
    
    public $full_name;
    public $email;
    public $phone;
    public $address;
    public $delivery_type;
    
    public function init()
    {
        $this->order = new Order();
        
        if ($this->user = Yii::$app->user->identity) {
            $this->full_name = $this->user->full_name;
            $this->email = $this->user->email;
            $this->phone = $this->user->phone;
            $this->address = $this->user->address;
        }
        
        return parent::init();
    }
    
    public function prepareRules()
    {
        return [
            'full_name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'email' => [
                ['required'],
                ['email'],
                ['string', 'max' => 100],
            ],
            'phone' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'address' => [
                ['required'],
                ['string', 'max' => 1000],
            ],
            'delivery_type' => [
                ['required'],
                ['in', 'range' => array_keys($this->order->enums->deliveryTypes())],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return $this->order->attributeLabels();
    }
    
    public function save()
    {
        //        Order creating
        
        $this->order->setAttributes([
            'user_id' => ArrayHelper::getValue($this->user, 'id'),
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'delivery_type' => $this->delivery_type,
        ]);
        
        if (!Yii::$app->services->cart->createOrder($this->order)) {
            return false;
        }
        
        //        Notifications
        
        Yii::$app->services->notification->create(
            User::find()->andWhere(['role_id' => 1])->column(),
            'order_created', $this->order->id,
            [
                'id' => $this->order->id,
            ]
        );
        
        //        Mailing
        
        Yii::$app->services->mail->send([$this->order->email], Yii::t('app_mail', 'Your order has been created'), 'order_created', [
            'order' => $this->order->attributes,
        ]);
        
        return $this->order->key;
    }
}
