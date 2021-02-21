<?php

namespace backend\modules\Order\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\AttributeBehavior;
use speedrunner\validators\UnchangeableValidator;

use backend\modules\User\models\User;


class Order extends ActiveRecord
{
    const SCENARIO_CHANGE_STATUS = 'change_status';
    
    public $products_tmp;
    
    public static function tableName()
    {
        return '{{%order}}';
    }
    
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_STATUS] = ['status'];
        
        return $scenarios;
    }
    
    public function behaviors()
    {
        return [
            'attributes' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'key',
                ],
                'value' => fn ($event) => md5(time() . Yii::$app->security->generateRandomString()),
            ],
            'relations_one_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
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
            [['delivery_type'], 'in', 'range' => array_keys($this->enums->deliveryTypes())],
            [['payment_type'], 'in', 'range' => array_keys($this->enums->paymentTypes())],
            [['payment_type'], 'default', 'value' => 'cash'],
            [['status'], 'in', 'range' => array_keys($this->enums->statuses())],
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
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id'])->orderBy('sort');
    }
    
    public function beforeSave($insert)
    {
        //        Changing products quantity
        
        $oldAttributes = $this->oldAttributes ?: $this->attributes;
        $old_status_action = ArrayHelper::getValue($this->enums->statuses(), "{$oldAttributes['status']}.save_action");
        $new_status_action = ArrayHelper::getValue($this->enums->statuses(), "$this->status.save_action");
        
        if ($new_status_action == 'minus') {
            $this->products_tmp = OrderProduct::find()->select(['id', 'product_id', 'quantity'])->indexBy('id')->asArray()->all();;
        }
        
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
