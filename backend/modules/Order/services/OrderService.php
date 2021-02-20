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
    
    public function changeStatus($status)
    {
        $this->model->scenario = $this->model::SCENARIO_CHANGE_STATUS;
        $this->model->status = $status;
        
        if ($this->model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('app', 'Status has been changed'));
        } else {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'An error occured'));
        }
    }
    
    public function changeProductsQuantity($new_status_action)
    {
        $transaction = Yii::$app->db->beginTransaction();
        
        foreach ($this->model->products as $p) {
            if (!$p->product) {
                continue;
            }
            
            $p->product->quantity += $new_status_action == 'plus' ? $p->quantity : (0 - $p->quantity);
            
            if (!$p->product->validate()) {
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