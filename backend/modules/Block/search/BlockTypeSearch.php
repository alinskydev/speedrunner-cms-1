<?php

namespace backend\modules\Block\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Block\models\BlockType;


class BlockTypeSearch extends BlockType
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'label', 'type', 'has_translation'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlockType::find();
        
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
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'has_translation', $this->has_translation]);
        
		return $dataProvider;
    }
}
