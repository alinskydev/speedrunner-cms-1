<?php

namespace backend\modules\Blog\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Blog\models\BlogRate;


class BlogRateSearch extends BlogRate
{
    public $item_name;
    
    public function rules()
    {
        return [
            [['id', 'blog_id', 'user_id', 'mark'], 'integer'],
            [['created'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlogRate::find()
            ->with(['blog', 'user']);
        
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
            'blog_id' => $this->blog_id,
            'user_id' => $this->user_id,
            'mark' => $this->mark,
        ]);
        
        $query->andFilterWhere(['like', 'created', $this->created]);
        
		return $dataProvider;
    }
}
