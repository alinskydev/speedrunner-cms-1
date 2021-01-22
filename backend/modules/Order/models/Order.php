<?php

namespace backend\modules\Order\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;

use backend\modules\User\models\User;


class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'Order';
    }
    
    public function rules()
    {
        return [
            [['delivery_type'], 'required'],
            [['delivery_price'], 'integer', 'min' => 1],
            [['delivery_type'], 'in', 'range' => array_keys($this->deliveryTypes())],
            [['payment_type'], 'in', 'range' => array_keys($this->paymentTypes())],
            [['status'], 'in', 'range' => array_keys($this->statuses())],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'user_id' => Yii::t('app', 'User'),
            'full_name' => Yii::t('app', 'Full name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'delivery_type' => Yii::t('app', 'Delivery type'),
            'payment_type' => Yii::t('app', 'Payment type'),
            
            'total_quantity' => Yii::t('app', 'Total quantity'),
            'total_price' => Yii::t('app', 'Total price'),
            'delivery_price' => Yii::t('app', 'Delivery price'),
            
            'status' => Yii::t('app', 'Status'),
            'key' => Yii::t('app', 'Key'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }
    
    static function deliveryTypes()
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
    
    static function paymentTypes()
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
    
    static function statuses()
    {
        return [
            'new' => [
                'label' => Yii::t('app', 'New'),
                'class' => 'primary',
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
    
    public function realTotalPrice()
    {
        return $this->total_price + $this->delivery_price;
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }
    
    public function beforeSave($insert)
    {
        if (!$insert && $this->status != $this->oldAttributes['status']) {
            $new_status_action = $this->statuses()[$this->status]['save_action'];
            $old_status_action = $this->statuses()[$this->oldAttributes['status']]['save_action'];
            
            if ($new_status_action != $old_status_action) {
                $transaction = Yii::$app->db->beginTransaction();
                
                foreach ($this->products as $p) {
                    $product = $p->product;
                    $product->quantity += $new_status_action == 'plus' ? $p->quantity : (0 - $p->quantity);
                    
                    if ($product->quantity < 0) {
                        Yii::$app->session->addFlash('danger', Yii::t('app', 'Not enough quantity for {product}', [
                            'product' => $product->name,
                        ]));
                        
                        $transaction->rollBack();
                        return false;
                    }
                    
                    $product->updateAttributes(['quantity' => $product->quantity]);
                }
                
                $transaction->commit();
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        NOTIFICATIONS
        
        if ($insert) {
            Yii::$app->sr->notification->create(
                User::find()->andWhere(['role' => 'admin'])->column(),
                'order_created', $this->id,
                [
                    'id' => $this->id,
                ]
            );
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function beforeDelete()
    {
        if ($this->statuses()[$this->status]['save_action'] == 'minus') {
            foreach ($this->products as $p) {
                $p->delete();
            }
        }
        
        return parent::beforeDelete();
    }
}
