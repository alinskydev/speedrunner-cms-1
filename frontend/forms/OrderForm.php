<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use common\services\CartService;
use backend\modules\User\services\UserNotificationService;

use backend\modules\Order\models\Order;
use backend\modules\Order\models\OrderProduct;
use backend\modules\Product\models\Product;
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
    
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'address', 'delivery_type'], 'required'],
            [['full_name', 'email', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['email'], 'email'],
            
            [['delivery_type'], 'in', 'range' => array_keys($this->order->deliveryTypes())],
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
        
        if (!(new CartService($this->order))->createOrder()) {
            return false;
        }
        
        //        Notifications
        
        UserNotificationService::create(
            User::find()->andWhere(['role' => 'admin'])->column(),
            'order_created', $this->order->id,
            [
                'id' => $this->order->id,
            ]
        );
        
        //        Mailing
        
        Yii::$app->services->mail->send($this->email, Yii::t('app_mail', 'Your order has been created'), 'order_created', [
            'key' => $this->order->key,
        ]);
        
        return $this->order->key;
    }
}
