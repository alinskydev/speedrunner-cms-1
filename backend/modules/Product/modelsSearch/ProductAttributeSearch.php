<?php

namespace backend\modules\Product\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Product\models\ProductAttribute;


class ProductAttributeSearch extends ProductAttribute
{
    public function rules()
    {
        return [
            [['id', 'use_filter', 'use_compare', 'use_detail'], 'integer'],
            [['name', 'code', 'type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductAttribute::find()->alias('self')->joinWith([
            'translation as translation',
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
            'type' => $this->type,
            'use_filter' => $this->use_filter,
            'use_compare' => $this->use_compare,
            'use_detail' => $this->use_detail,
        ]);

        $query->andFilterWhere(['like', 'translation.name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

		$this->afterSearch();
		return $dataProvider;
    }
}
