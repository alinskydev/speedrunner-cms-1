<?php

namespace backend\modules\Product\search;

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
            [['name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function search()
    {
        $query = ProductSpecification::find();
        
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
            'use_filter' => $this->use_filter,
            'use_compare' => $this->use_compare,
            'use_detail' => $this->use_detail,
        ]);
        
        $query->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);
        
        //        Translations
        
        $lang = Yii::$app->language;
        
        foreach ($this->behaviors['translation']->attributes as $t_a) {
            $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($t_a, '$.$lang'))"), strtolower($this->{$t_a})]);
            $query->addSelect(['*', new Expression("$t_a->>'$.$lang' as json_$t_a")]);
            
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ["json_$t_a" => SORT_ASC],
                'desc' => ["json_$t_a" => SORT_DESC],
            ];
        }
        
		return $dataProvider;
    }
}
