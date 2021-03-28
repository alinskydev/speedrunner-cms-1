<?php

namespace speedrunner\services;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;
use backend\modules\Product\models\Product;


class CartService
{
    public static function changeQuantity(Product $product, int $quantity)
    {
        if ($product->quantity < $quantity) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Not enough quantity'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $cart = Yii::$app->session->get('cart', []);
        
        if ($quantity > 0) {
            $cart['products'][$product->id] = $product->attributes;
            $cart['products'][$product->id]['total_quantity'] = $quantity;
            $cart['products'][$product->id]['total_price'] = $product->service->realPrice() * $quantity;
        } else {
            ArrayHelper::remove($cart['products'], $product->id);
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
    
    public static function createOrder(Order $order)
    {
        $total_price = 0;
        $total_quantity = 0;
        
        $cart = Yii::$app->session->get('cart', []);
        $cart_products = ArrayHelper::getValue($cart, 'products', []);
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
