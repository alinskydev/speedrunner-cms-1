<?php

namespace common\services;

use Yii;
use yii\helpers\ArrayHelper;
use common\framework\ActiveRecord;


class CartService
{
    private $order;
    private $product;
    
    public function __construct(ActiveRecord $order, ActiveRecord $product)
    {
        $this->order = $order;
        $this->product = $product;
    }
    
    public function changeQuantity(int $quantity)
    {
        if ($this->product->quantity < $quantity) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Not enough quantity'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $cart = Yii::$app->session->get('cart', []);
        
        if ($quantity > 0) {
            $cart['products'][$id] = $this->product->attributes;
            $cart['products'][$id]['total_quantity'] = $quantity;
            $cart['products'][$id]['total_price'] = $this->product->realPrice() * $quantity;
        } else {
            ArrayHelper::remove($cart['products'], $id);
        }
        
        if ($cart['products']) {
            $quantities = ArrayHelper::getColumn($cart['products'], 'total_quantity');
            $total_prices = ArrayHelper::getColumn($cart['products'], 'total_price');
            
            $cart['total'] = [
                'quantity' => array_sum($quantities),
                'price' => array_sum($total_prices),
            ];
            
            Yii::$app->session->set('cart', $cart);
        } else {
            Yii::$app->session->remove('cart');
        }
        
        return $cart;
    }
    
    public function createOrder()
    {
        $total_price = 0;
        $total_quantity = 0;
        
        $cart = Yii::$app->session->get('cart', []);
        $cart_products = ArrayHelper::getValue($cart, 'products', []);
        $cart_products = ArrayHelper::getColumn($cart_products, 'total_quantity');
        
        $products = $this->product->find()->andWhere(['id' => array_keys($cart_products)])->all();
        
        foreach ($products as $key => $p) {
            $order_products[] = [
                'product_id' => $p->id,
                'quantity' => ArrayHelper::getValue($cart_products, $p->id),
            ];
        }
        
        $this->order->products_tmp = $order_products ?? [];
        
        if (!$this->order->save()) {
            return false;
        }
        
        Yii::$app->session->remove('cart');
        return true;
    }
}
