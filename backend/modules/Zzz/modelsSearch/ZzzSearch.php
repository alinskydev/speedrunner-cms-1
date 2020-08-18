<?php

namespace backend\modules\Zzz\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use backend\modules\Zzz\models\Zzz;


class ZzzSearch extends Zzz
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
            [['id', 'category_id'], 'integer'],
            [['name', 'url', 'created', 'updated'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Zzz::find()->with(['category']);

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
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'created', $this->created])
            ->andFilterWhere(['like', 'updated', $this->updated]);
        
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