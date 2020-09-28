<?php

namespace backend\modules\Product\models;

use Yii;
use common\components\framework\ActiveRecord;
use backend\modules\User\models\User;


class ProductComment extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProductComment';
    }
    
    public function rules()
    {
        return [
            [['product_id', 'text'], 'required'],
            [['status'], 'in', 'range' => array_keys(Yii::$app->params['comment_statuses'])],
            [['text'], 'string', 'max' => 1000],
            
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product'),
            'user_id' => Yii::t('app', 'User'),
            'text' => Yii::t('app', 'Text'),
            'status' => Yii::t('app', 'Status'),
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
    
    public function beforeSave($insert)
    {
        $this->text = strip_tags($this->text);
        
        return parent::beforeSave($insert);
    }
}
