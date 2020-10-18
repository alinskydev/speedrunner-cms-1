<?php

namespace backend\modules\Translation\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Translation\models\TranslationSource;


class TranslationSourceSearch extends TranslationSource
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'message', 'translations_tmp'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = TranslationSource::find()
            ->joinWith(['translations'])
            ->with(['translations.lang'])
            ->distinct();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [1, 30],
                'totalCount' => $query->count(),
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
            'TranslationSource.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'TranslationSource.category', $this->category])
            ->andFilterWhere(['like', 'TranslationSource.message', $this->message])
            ->andFilterWhere(['like', 'TranslationMessage.translation', $this->translations_tmp]);

		$this->afterSearch();
		return $dataProvider;
    }
}
