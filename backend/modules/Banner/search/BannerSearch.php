<?php

namespace backend\modules\Banner\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Banner\models\Banner;


class BannerSearch extends Banner
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'location', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = Banner::find();
        
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
            'location' => $this->location,
        ]);
        
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);
        
		return $dataProvider;
    }
}
