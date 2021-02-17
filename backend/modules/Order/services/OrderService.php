<?php

namespace backend\modules\Order\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;


class OrderService extends ActiveService
{
    public function realTotalPrice()
    {
        return $this->model->total_price + $this->model->delivery_price;
    }
    
    public function changeProductsQuantity($new_status_action)
    {
        $transaction = Yii::$app->db->beginTransaction();
        
        foreach ($this->model->products as $p) {
            $p->product->quantity += $new_status_action == 'plus' ? $p->quantity : (0 - $p->quantity);
            
            if (!$p->product->validate()) {
                Yii::$app->session->removeFlash('success');
                Yii::$app->session->addFlash('danger', Yii::t('app', 'Not enough quantity for {product}', [
                    'product' => $p->product->name,
                ]));
                
                $transaction->rollBack();
                return false;
            }
            
            $p->product->updateAttributes(['quantity' => $p->product->quantity]);
        }
        
        $transaction->commit();
        return true;
    }
}