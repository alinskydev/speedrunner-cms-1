<?php

namespace backend\modules\Order\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Order\models\Order;


class OrderSearch extends Order
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'total_quantity', 'total_price', 'delivery_price'], 'integer'],
            [['full_name', 'phone', 'email', 'delivery_type', 'payment_type'], 'safe'],
            [['status', 'key', 'created', 'updated'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = Order::find()
            ->with(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [1, 30],
                'totalCount' => $query->count(),
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);

        $this->load($params);
		$this->beforeSearch();

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total_quantity' => $this->total_quantity,
            'delivery_type' => $this->delivery_type,
            'payment_type' => $this->payment_type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'total_price', $this->total_price])
            ->andFilterWhere(['like', 'delivery_price', $this->delivery_price])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'created', $this->created])
            ->andFilterWhere(['like', 'updated', $this->updated]);

        $query->andFilterWhere([
            'or',
            ['like', 'full_name', $this->full_name],
            ['like', 'phone', $this->full_name],
            ['like', 'email', $this->full_name],
        ]);

		$this->afterSearch();
		return $dataProvider;
    }
}
