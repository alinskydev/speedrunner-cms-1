<?php

namespace backend\modules\Product\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Product\models\Product;


class ProductSearch extends Product
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['sluggable']);
        
        return $behaviors;
    }
    
    public function rules()
    {
        return [
            [['id', 'brand_id', 'main_category_id', 'quantity', 'is_active'], 'integer'],
            [['name', 'url', 'sku', 'sale', 'created', 'updated'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Product::find()->alias('self')->joinWith([
            'translation as translation',
        ])->with([
            'brand.translation',
            'mainCat.translation',
            'images',
        ]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        
        foreach ($this->translation_attrs as $t_a) {
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ['translation.' . $t_a => SORT_ASC],
                'desc' => ['translation.' . $t_a => SORT_DESC],
            ];
        }

        $this->load($params);
		$this->beforeSearch();

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'self.id' => $this->id,
            'brand_id' => $this->brand_id,
            'main_category_id' => $this->main_category_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sale' => $this->sale,
            'self.is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'translation.name', $this->name])
            ->andFilterWhere(['like', 'self.url', $this->url])
            ->andFilterWhere(['like', 'self.sku', $this->sku])
            ->andFilterWhere(['like', 'self.created', $this->created])
            ->andFilterWhere(['like', 'self.updated', $this->updated]);

		$this->afterSearch();
		return $dataProvider;
    }
}
