<?php

namespace speedrunner\services;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;
use backend\modules\Product\models\Product;


class CartService
{
    public $cart;
    
    public function __construct()
    {
        $this->cart = Yii::$app->session->get('cart', []);
    }
    
    public function changeQuantity(Product $product, int $quantity)
    {
        if ($product->quantity < $quantity) {
            Yii::$app->session->addFlash('warning', Yii::t('app', 'Not enough quantity'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($quantity > 0) {
            $this->cart['products'][$product->id] = $product->attributes;
            $this->cart['products'][$product->id]['total_quantity'] = $quantity;
            $this->cart['products'][$product->id]['total_price'] = $product->service->realPrice() * $quantity;
        } else {
            ArrayHelper::remove($this->cart['products'], $product->id);
        }
        
        if ($this->cart['products']) {
            $quantities = ArrayHelper::getColumn($this->cart['products'], 'total_quantity');
            $total_prices = ArrayHelper::getColumn($this->cart['products'], 'total_price');
            
            $this->cart['total'] = [
                'quantity' => array_sum($quantities),
                'price' => array_sum($total_prices),
            ];
            
            Yii::$app->session->set('cart', $this->cart);
        } else {
            Yii::$app->session->remove('cart');
        }
        
        return $this->cart;
    }
    
    public function createOrder(Order $order)
    {
        $total_price = 0;
        $total_quantity = 0;
        
        $cart_products = ArrayHelper::getValue($this->cart, 'products', []);
        $cart_products = ArrayHelper::getColumn($cart_products, 'total_quantity');
        
        $products = Product::find()->andWhere(['id' => array_keys($cart_products)])->all();
        
        foreach ($products as $key => $p) {
            $order_products[] = [
                'product_id' => $p->id,
                'quantity' => ArrayHelper::getValue($cart_products, $p->id),
            ];
        }
        
        $order->products_tmp = $order_products ?? [];
        
        if (!$order->save()) {
            return false;
        }
        
        Yii::$app->session->remove('cart');
        return true;
    }
}
