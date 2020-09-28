<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;
use backend\modules\Order\models\OrderProduct;
use backend\modules\Product\models\Product;


class OrderForm extends Model
{
    const EXCEPT_ATTRS = ['user', 'order'];
    
    public $user;
    public $order;
    
    public $full_name;
    public $email;
    public $phone;
    public $address;
    public $delivery_type;
    
    public function init()
    {
        $this->order = new Order;
        
        if ($this->user = Yii::$app->user->identity) {
            $this->full_name = $this->user->full_name;
            $this->email = $this->user->username;
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
        $total_price = 0;
        $total_quantity = 0;
        
        $cart = Yii::$app->session->get('cart', []);
        $cart_products = ArrayHelper::getValue($cart, 'products', []);
        $cart_products = ArrayHelper::getColumn($cart_products, 'total_quantity');
        
        $transaction = Yii::$app->db->beginTransaction();
        $order = $this->order;
        
        foreach ($this->attributes as $key => $a) {
            if (!in_array($key, self::EXCEPT_ATTRS)) {
                $order->{$key} = $a;
            }
        }
        
        $order->user_id = ArrayHelper::getValue($this->user, 'id');
        $order->key = md5(time() . Yii::$app->security->generateRandomString());
        
        if ($order->save()) {
            $products = Product::find()
                ->andWhere([
                    'and',
                    ['id' => array_keys($cart_products)],
                    ['>', 'quantity', 0],
                ])
                ->all();
            
            foreach ($products as $key => $p) {
                $quantity = ArrayHelper::getValue($cart_products, $p->id);
                
                if ($quantity > $p->quantity) {
                    continue;
                }
                
                $order_product = new OrderProduct;
                $order_product->order_id = $order->id;
                $order_product->product_id  = $p->id;
                $order_product->product_json = $p->attributes;
                $order_product->price = $p->realPrice();
                $order_product->quantity = $quantity;
                $order_product->total_price = $order_product->price * $order_product->quantity;
                
                if ($order_product->save()) {
                    $total_price += $order_product->total_price;
                    $total_quantity += $order_product->quantity;
                }
            }
        }
        
        if (!$total_price || !$total_quantity) {
            $transaction->rollBack();
            return false;
        }
        
        $transaction->commit();
        Yii::$app->session->remove('cart');
        
        $order->updateAttributes([
            'total_quantity' => $total_quantity,
            'total_price' => $total_price,
        ]);
        
        return $order->key;
    }
}
