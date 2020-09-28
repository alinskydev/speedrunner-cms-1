<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use backend\modules\User\models\User;


class ProductRate extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductRate';
    }
    
    public function rules()
    {
        return [
            [['product_id', 'mark'], 'required'],
            [['mark'], 'integer', 'min' => 1, 'max' => 10],
            
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product'),
            'user_id' => Yii::t('app', 'User'),
            'mark' => Yii::t('app', 'Mark'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
    
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
