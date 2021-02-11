<?php

namespace backend\modules\Order\services;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Order\models\Order;


class OrderService
{
    private $model;
    
    public function __construct(Order $model)
    {
        $this->model = $model;
    }
    
    public function changeProductsQuantity($new_status_action)
    {
        $transaction = Yii::$app->db->beginTransaction();
        
        foreach ($this->model->products as $p) {
            $p->product->quantity += $new_status_action == 'plus' ? $p->quantity : (0 - $p->quantity);
            
            if (!$p->product->save()) {
                Yii::$app->session->removeFlash('success');
                Yii::$app->session->addFlash('danger', Yii::t('app', 'Not enough quantity for {product}', [
                    'product' => $p->product->name,
                ]));
                
                $transaction->rollBack();
                return false;
            }
        }
        
        $transaction->commit();
        return true;
    }
}