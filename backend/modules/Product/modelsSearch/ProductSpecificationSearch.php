<?php

namespace backend\modules\Product\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use backend\modules\Product\models\ProductSpecification;


class ProductSpecificationSearch extends ProductSpecification
{
    public function rules()
    {
        return [
            [['id', 'use_filter', 'use_compare', 'use_detail'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductSpecification::find();

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
            'use_filter' => $this->use_filter,
            'use_compare' => $this->use_compare,
            'use_detail' => $this->use_detail,
        ]);
        
        //        TRANSLATIONS
        
        $lang = Yii::$app->language;
        
        foreach ($this->translation_attributes as $t_a) {
            $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($t_a, '$.$lang'))"), strtolower($this->{$t_a})]);
            $query->addSelect(['*', new Expression("$t_a->>'$.$lang' as json_$t_a")]);
            
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ["json_$t_a" => SORT_ASC],
                'desc' => ["json_$t_a" => SORT_DESC],
            ];
        }

		$this->afterSearch();
		return $dataProvider;
    }
}
