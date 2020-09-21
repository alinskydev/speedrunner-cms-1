<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

use backend\modules\Product\models\Product;


class CartController extends Controller
{
    public function actionIndex()
    {
        $page = Yii::$app->sr->record->staticpage('cart');
        
        $render_type = Yii::$app->request->isAjax ? 'renderPartial' : 'render';
        
        return $this->{$render_type}('index', [
            'page' => $page['page'],
            'blocks' => $page['blocks'],
            'cart' => Yii::$app->session->get('cart'),
        ]);
    }
    
    public function actionPreview()
    {
        return $this->renderPartial('preview', [
            'cart' => Yii::$app->session->get('cart'),
        ]);
    }
    
    public function actionChange()
    {
        //        PREPARE
        
        $id = Yii::$app->request->post('id');
        $quantity = intval(Yii::$app->request->post('quantity'));
        
        if (!$id || !($product = Product::findOne($id))) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Product not found'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if ($product->quantity < $quantity) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Not enough quantity'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        //        CART
        
        $cart = Yii::$app->session->get('cart', []);
        
        if ($quantity > 0) {
            $cart['products'][$id] = $product->attributes;
            $cart['products'][$id]['total_quantity'] = $quantity;
            $cart['products'][$id]['total_price'] = $product->realPrice() * $quantity;
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
        
        $result['quantity'] = ArrayHelper::getValue(Yii::$app->session->get('cart'), 'total.quantity', 0);
        $result['preview'] = $this->runAction('preview');
        $result['page'] = $this->runAction('index');
        
        return $this->asJson($result);
    }
}
