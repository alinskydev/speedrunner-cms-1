<?php

namespace backend\modules\Order\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            ->with(['user'])
            ->select([
                '*',
                "(total_price) + (delivery_price) as checkout_price",
            ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [1, 30],
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        
        if (!$this->validate()) {
            $query->andWhere('false');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'delivery_type' => $this->delivery_type,
            'payment_type' => $this->payment_type,
            'status' => $this->status,
        ]);
        
        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);
        
        $query->andFilterWhere([
            'or',
            ['like', 'full_name', $this->full_name],
            ['like', 'phone', $this->full_name],
            ['like', 'email', $this->full_name],
        ]);
        
        $query->andFilterWhere([
            "(total_price) + (delivery_price)" => $this->checkout_price,
        ]);
        
        $dataProvider->sort->attributes['checkout_price'] = [
            'asc' => ['checkout_price' => SORT_ASC],
            'desc' => ['checkout_price' => SORT_DESC],
        ];
        
		return $dataProvider;
    }
}
