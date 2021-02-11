<?php

namespace backend\modules\Order\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use backend\modules\Order\services\OrderService;

use backend\modules\User\models\User;


class Order extends ActiveRecord
{
    public $products_tmp;
    
    public static function tableName()
    {
        return 'Order';
    }
    
    public function behaviors()
    {
        return [
            'relations_one_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'products_tmp' => [
                        'model' => new OrderProduct(),
                        'relation' => 'products',
                        'attributes' => [
                            'main' => 'order_id',
                            'relational' => ['product_id', 'quantity'],
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'address', 'delivery_type', 'products_tmp'], 'required'],
            [['full_name', 'email', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['email'], 'email'],
            [['delivery_price'], 'integer', 'min' => 1],
            [['delivery_type'], 'in', 'range' => array_keys($this->deliveryTypes())],
            [['payment_type'], 'in', 'range' => array_keys($this->paymentTypes())],
            [['payment_type'], 'default', 'value' => 'cash'],
            [['status'], 'in', 'range' => array_keys($this->statuses())],
            [['products_tmp'], 'safe'],
            
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
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
            
            'products_tmp' => Yii::t('app', 'Products'),
        ];
    }
    
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
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id'])->orderBy('sort');
    }
    
    public function beforeValidate()
    {
        if (!$this->isNewRecord && ArrayHelper::getValue($this->statuses(), "{$this->oldAttributes['status']}.save_action") == 'minus') {
            $this->products_tmp = OrderProduct::find()->select(['id', 'product_id', 'quantity'])->indexBy('id')->asArray()->all();
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        //        Generating secret key
        
        if ($insert) {
            $this->status = 'new';
            $this->key = md5(time() . Yii::$app->security->generateRandomString());
        }
        
        //        Changing products quantity
        
        if (!$insert) {
            $new_status_action = ArrayHelper::getValue($this->statuses(), "$this->status.save_action");
            $old_status_action = ArrayHelper::getValue($this->statuses(), "{$this->oldAttributes['status']}.save_action");
            
            if ($new_status_action != $old_status_action) {
                $order_service = new OrderService($this);
                
                if (!$order_service->changeProductsQuantity($new_status_action)) {
                    return false;
                }
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        Total quantity and price
        
        parent::afterSave($insert, $changedAttributes);
        $this->refresh();
        
        $this->updateAttributes([
            'total_quantity' => array_sum(ArrayHelper::getColumn($this->products, 'quantity', [])),
            'total_price' => array_sum(ArrayHelper::getColumn($this->products, 'total_price', [])),
        ]);
    }
    
    public function beforeDelete()
    {
        foreach ($this->products as $value) { $value->delete(); }
        return parent::beforeDelete();
    }
}
