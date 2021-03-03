<?php

namespace backend\modules\Blog\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Blog\models\BlogTag;


class BlogTagSearch extends BlogTag
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'created_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlogTag::find();
        
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
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);
        
		return $dataProvider;
    }
}
