<?php

namespace backend\modules\Order\enums;

use Yii;


class OrderEnums
{
    public static function deliveryTypes()
    {
        return [
            'pickup' => [
                'label' => Yii::t('app', 'Pickup'),
            ],
            'delivery' => [
                'label' => Yii::t('app', 'Delivery'),
            ],
        ];
    }
    
    public static function paymentTypes()
    {
        return [
            'cash' => [
                'label' => Yii::t('app', 'Cash'),
            ],
            'bank_card' => [
                'label' => Yii::t('app', 'Bank card'),
            ],
        ];
    }
    
    public static function statuses()
    {
        return [
            'new' => [
                'label' => Yii::t('app', 'New'),
                'class' => 'light',
                'save_action' => 'plus',
            ],
            'confirmed' => [
                'label' => Yii::t('app', 'Confirmed'),
                'class' => 'warning',
                'save_action' => 'minus',
            ],
            'payed' => [
                'label' => Yii::t('app', 'Payed'),
                'class' => 'info',
                'save_action' => 'minus',
            ],
            'completed' => [
                'label' => Yii::t('app', 'Completed'),
                'class' => 'success',
                'save_action' => 'minus',
            ],
            'canceled' => [
                'label' => Yii::t('app', 'Canceled'),
                'class' => 'danger',
                'save_action' => 'plus',
            ],
        ];
    }
}