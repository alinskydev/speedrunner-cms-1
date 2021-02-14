<?php

namespace backend\modules\Blog\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use backend\modules\Blog\models\Blog;


class BlogSearch extends Blog
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
            [['id', 'category_id', 'tags_tmp'], 'integer'],
            [['name', 'slug', 'created', 'updated', 'published'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = Blog::find()
            ->joinWith(['tags'])
            ->with(['category'])
            ->select(['Blog.*'])
            ->groupBy('id');
        
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
            'Blog.id' => $this->id,
            'Blog.category_id' => $this->category_id,
        ]);
        
        $query->andFilterWhere(['like', 'Blog.slug', $this->slug])
            ->andFilterWhere(['like', 'Blog.published', $this->published])
            ->andFilterWhere(['like', 'Blog.created', $this->created])
            ->andFilterWhere(['like', 'Blog.updated', $this->updated])
            ->andFilterWhere(['like', 'BlogTag.id', $this->tags_tmp]);
        
        //        Translations
        
        $lang = Yii::$app->language;
        
        foreach ($this->behaviors['translation']->attributes as $t_a) {
            $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT(Blog.$t_a, '$.$lang'))"), strtolower($this->{$t_a})]);
            $query->addSelect([new Expression("Blog.$t_a->>'$.$lang' as json_$t_a")]);
            
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ["json_$t_a" => SORT_ASC],
                'desc' => ["json_$t_a" => SORT_DESC],
            ];
        }
        
		return $dataProvider;
    }
}