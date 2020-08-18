<?php

namespace backend\modules\Product\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

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
        $query = ProductAttribute::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
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
            'type' => $this->type,
            'use_filter' => $this->use_filter,
            'use_compare' => $this->use_compare,
            'use_detail' => $this->use_detail,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);
        
        //        TRANSLATIONS
        
        $lang = Yii::$app->language;
        
        foreach ($this->translation_attrs as $t_a) {
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
