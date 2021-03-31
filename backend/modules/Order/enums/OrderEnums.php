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
            'online' => [
                'label' => Yii::t('app', 'Online'),
            ],
        ];
    }
    
    public static function statuses()
    {
        return [
            'new' => [
                'label' => Yii::t('app', 'New'),
                'class' => 'light',
                'products_action' => 'plus',
            ],
            'confirmed' => [
                'label' => Yii::t('app', 'Confirmed'),
                'class' => 'warning',
                'products_action' => 'minus',
            ],
            'payed' => [
                'label' => Yii::t('app', 'Payed'),
                'class' => 'info',
                'products_action' => 'minus',
            ],
            'completed' => [
                'label' => Yii::t('app', 'Completed'),
                'class' => 'success',
                'products_action' => 'minus',
            ],
            'canceled' => [
                'label' => Yii::t('app', 'Canceled'),
                'class' => 'danger',
                'products_action' => 'plus',
            ],
        ];
    }
}