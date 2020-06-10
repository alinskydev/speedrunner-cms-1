<?php

namespace backend\modules\StaticPage\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\StaticPage\models\StaticPage;


class StaticPageSearch extends StaticPage
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
            [['name', 'url', 'created', 'updated'], 'safe'],
        ];
    }
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = StaticPage::find()->alias('self');
        $query->joinWith(['translation as translation']);
        
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
        ]);

        $query->andFilterWhere(['like', 'translation.name', $this->name])
            ->andFilterWhere(['like', 'self.url', $this->url])
            ->andFilterWhere(['like', 'self.created', $this->created])
            ->andFilterWhere(['like', 'self.updated', $this->updated]);
        
		$this->afterSearch();
		return $dataProvider;
    }
}