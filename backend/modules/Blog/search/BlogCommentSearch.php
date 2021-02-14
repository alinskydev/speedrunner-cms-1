<?php

namespace backend\modules\Blog\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Blog\models\BlogComment;


class BlogCommentSearch extends BlogComment
{
    public function rules()
    {
        return [
            [['id', 'blog_id', 'user_id'], 'integer'],
            [['text', 'status', 'created'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlogComment::find()
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
            'status' => $this->status,
        ]);
        
        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'created', $this->created]);
        
		return $dataProvider;
    }
}
