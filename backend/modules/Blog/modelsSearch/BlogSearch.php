<?php

namespace backend\modules\Blog\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

use backend\modules\Blog\models\Blog;


class BlogSearch extends Blog
{
    public $tag_id;
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['sluggable']);
        
        return $behaviors;
    }
    
    public function rules()
    {
        return [
            [['id', 'category_id', 'tag_id'], 'integer'],
            [['name', 'slug', 'created', 'updated', 'published'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
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
        
        $this->load($params);
		$this->beforeSearch();
        
        if (!$this->validate()) {
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
            ->andFilterWhere(['like', 'BlogTag.id', $this->tag_id]);
        
        //        TRANSLATIONS
        
        $lang = Yii::$app->language;
        
        foreach ($this->behaviors['translation']->attributes as $t_a) {
            $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT(Blog.$t_a, '$.$lang'))"), strtolower($this->{$t_a})]);
            $query->addSelect([new Expression("Blog.$t_a->>'$.$lang' as json_$t_a")]);
            
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ["json_$t_a" => SORT_ASC],
                'desc' => ["json_$t_a" => SORT_DESC],
            ];
        }
        
        $dataProvider->pagination->totalCount = $query->count();
        
		$this->afterSearch();
		return $dataProvider;
    }
}