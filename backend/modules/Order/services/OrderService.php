<?php

namespace backend\modules\Order\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;


class OrderService extends ActiveService
{
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
            $relation_name = $p->variation ? 'variation' : 'product';
            
            if (!($relation_model = $p->{$relation_name})) {
                continue;
            }
            
            $relation_model->quantity += $new_status_action == 'plus' ? $p->quantity : (0 - $p->quantity);
            
            if (!$relation_model->validate()) {
                Yii::$app->session->addFlash('danger', Yii::t('app', 'Not enough quantity for {product}', [
                    'product' => $relation_model->name,
                ]));
                
                $transaction->rollBack();
                return false;
            }
            
            $relation_model->updateAttributes(['quantity' => $relation_model->quantity]);
            
            if ($relation_name == 'variation' && $p->product) {
                $p->product->scenario = $p->product::SCENARIO_CHANGE_QUANTITY;
                $p->product->service->assignVariationAttributes($p->product->variations[0], false);
                $p->product->save();
            }
        }
        
        $transaction->commit();
        return true;
    }
}