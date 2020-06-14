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
        $query = BlogRate::find()->with(['blog', 'user']);

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
            'blog_id' => $this->blog_id,
            'user_id' => $this->user_id,
            'mark' => $this->mark,
        ]);

        $query->andFilterWhere(['like', 'created', $this->created]);

		$this->afterSearch();
		return $dataProvider;
    }
}
