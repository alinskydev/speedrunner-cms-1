<?php

namespace backend\modules\Product\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Product\models\ProductRate;


class ProductRateSearch extends ProductRate
{
    public $item_name;
    
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id', 'mark'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductRate::find()
            ->with(['product', 'user']);

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
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'mark' => $this->mark,
        ]);

        $query->andFilterWhere(['like', 'created', $this->created]);

		$this->afterSearch();
		return $dataProvider;
    }
}
