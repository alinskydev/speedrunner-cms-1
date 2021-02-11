<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\services\CartService;


class CartController extends Controller
{
    public function actionIndex()
    {
        $page = Yii::$app->services->staticpage->cart;
        
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
        if (!$id || !($product = Product::findOne(Yii::$app->request->post('id'))) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Product not found'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $cart = (new CartService)->changeQuantity($product, (int)Yii::$app->request->post('quantity'));
        
        return $this->asJson([
            'quantity' => ArrayHelper::getValue($cart, 'total.quantity', 0),
            'preview' => $this->runAction('preview'),
            'page' => $this->runAction('index'),
        ]);
    }
}
