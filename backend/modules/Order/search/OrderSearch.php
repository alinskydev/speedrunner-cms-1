<?php

namespace backend\modules\Order\search;

use Yii;
use yii\base\Model;

use backend\modules\Order\models\Order;


class OrderSearch extends Order
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'total_price', 'checkout_price'], 'integer'],
            [['full_name', 'phone', 'email', 'delivery_type', 'payment_type'], 'safe'],
            [['status', 'key', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = Order::find()
            ->with(['user']);
        
        $query->andFilterWhere([
            'or',
            ['like', 'full_name', $this->full_name],
            ['like', 'phone', $this->full_name],
            ['like', 'email', $this->full_name],
        ]);
        
        $query->andFilterWhere([
            "(total_price) + (delivery_price)" => $this->checkout_price,
        ]);
        
        $attribute_groups = [
            '=' => ['id', 'user_id', 'total_price', 'delivery_type', 'payment_type', 'status'],
            'like' => ['phone', 'email', 'key', 'created_at', 'updated_at'],
        ];
        
        $dataProvider = Yii::$app->services->data->search($this, $query, $attribute_groups);
        
        $dataProvider->sort->attributes['checkout_price'] = [
            'asc' => ['checkout_price' => SORT_ASC],
            'desc' => ['checkout_price' => SORT_DESC],
        ];
        
		return $dataProvider;
    }
}
