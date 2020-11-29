<?php

namespace backend\modules\System\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\System\models\SystemLanguage;


class SystemLanguageSearch extends SystemLanguage
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'is_main'], 'integer'],
            [['name', 'code', 'image', 'created', 'updated'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SystemLanguage::find();

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
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_main' => $this->is_main,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'created', $this->created])
            ->andFilterWhere(['like', 'updated', $this->updated]);
        
        $dataProvider->pagination->totalCount = $query->count();

		$this->afterSearch();
		return $dataProvider;
    }
}
