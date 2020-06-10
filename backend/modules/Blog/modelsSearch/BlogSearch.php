<?php

namespace backend\modules\Blog\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Blog\models\Blog;


class BlogSearch extends Blog
{
    public $published_from;
    public $published_to;
    
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
            [['name', 'url', 'created', 'updated', 'published', 'published_from', 'published_to'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Blog::find()->alias('self')->joinWith([
            'translation as translation',
        ])->with([
            'category.translation',
            'tags',
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
            'self.category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'translation.name', $this->name])
            ->andFilterWhere(['like', 'self.url', $this->url])
            ->andFilterWhere(['like', 'self.created', $this->created])
            ->andFilterWhere(['like', 'self.updated', $this->updated])
            ->andFilterWhere(['like', 'published', $this->published]);
        
        if ($this->published_from && $this->published_to) {
            $query->andFilterWhere([
                'and',
                ['>=', 'published', date('Y-m-d', strtotime($this->published_from))],
                ['<=', 'published', date('Y-m-d', strtotime($this->published_to))],
            ]);
        }
        
		$this->afterSearch();
		return $dataProvider;
    }
}