<?php

namespace backend\modules\Block\modelsSearch;

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

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = BlockType::find();

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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'has_translation', $this->has_translation]);

		$this->afterSearch();
		return $dataProvider;
    }
}
