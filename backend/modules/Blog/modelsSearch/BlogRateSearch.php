<?php

namespace backend\modules\Blog\modelsSearch;

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

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BlogRate::find()->alias('self')
            ->with(['blog.translation', 'user']);

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
            'self.id' => $this->id,
            'self.blog_id' => $this->blog_id,
            'self.user_id' => $this->user_id,
            'self.mark' => $this->mark,
        ]);

        $query->andFilterWhere(['like', 'self.created', $this->created]);

		$this->afterSearch();
		return $dataProvider;
    }
}
