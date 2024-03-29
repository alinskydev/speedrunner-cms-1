<?php

namespace backend\modules\Order\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use backend\modules\User\models\User;


class Order extends ActiveRecord
{
    public $products_tmp;
    
    public $checkout_price;
    
    public static function tableName()
    {
        return '{{%order}}';
    }
    
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'change_status' => ['status'],
        ]);
    }
    
    public function behaviors()
    {
        return [
            'relations_one_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'products_tmp' => [
                        'model' => new OrderProduct(),
                        'relation' => 'products',
                        'attributes' => [
                            'main' => 'order_id',
                            'relational' => ['product_id', 'variation_id', 'quantity'],
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function prepareRules()
    {
        return [
            'user_id' => [
                ['exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ],
            'full_name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'email' => [
                ['required'],
                ['email'],
                ['string', 'max' => 100],
            ],
            'phone' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'address' => [
                ['required'],
                ['string', 'max' => 1000],
            ],
            'delivery_type' => [
                ['required'],
                ['in', 'range' => array_keys($this->enums->deliveryTypes())],
            ],
            'delivery_price' => [
                ['integer', 'min' => 0],
                ['default', 'value' => 0],
            ],
            'payment_type' => [
                ['required'],
                ['in', 'range' => array_keys($this->enums->paymentTypes())],
            ],
            'status' => [
                ['in', 'range' => array_keys($this->enums->statuses())],
            ],
            'products_tmp' => [
                ['required'],
                ['safe'],
            ],
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
            'checkout_price' => Yii::t('app', 'Checkout price'),
            
            'status' => Yii::t('app', 'Status'),
            'key' => Yii::t('app', 'Key'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'products_tmp' => Yii::t('app', 'Products'),
        ];
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id'])->orderBy('sort');
    }
    
    public function afterFind()
    {
        $this->checkout_price = $this->total_price + $this->delivery_price;
        return parent::afterFind();
    }
    
    public function beforeSave($insert)
    {
        //        Setting random key
        
        if ($insert) {
            $this->key = Yii::$app->helpers->string->randomize();
        }
        
        //        Setting old products
        
        $oldAttributes = $this->oldAttributes ?: $this->attributes;
        $old_status_action = ArrayHelper::getValue($this->enums->statuses(), "{$oldAttributes['status']}.products_action");
        $new_status_action = ArrayHelper::getValue($this->enums->statuses(), "$this->status.products_action");
        
        if (!$insert && $this->scenario == 'default' && $this->status != 'new') {
            $this->products_tmp = ArrayHelper::index($this->products, 'id');
        }
        
        //        Changing products quantity
        
        if ($new_status_action != $old_status_action) {
            if (!$this->service->changeProductsQuantity($new_status_action)) {
                return false;
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
