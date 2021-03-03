<?php

namespace backend\modules\Product\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use backend\modules\Product\models\ProductBrand;


class ProductBrandSearch extends ProductBrand
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
            [['id'], 'integer'],
            [['name', 'slug', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = ProductBrand::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [1, 30],
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);
        
        if (!$this->validate()) {
            $query->andWhere('false');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        
        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
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
