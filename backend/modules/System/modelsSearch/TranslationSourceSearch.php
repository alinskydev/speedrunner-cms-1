<?php

namespace backend\modules\System\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\System\models\TranslationSource;


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
            ->with(['translations.language'])
            ->distinct();

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
            'TranslationSource.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'TranslationSource.category', $this->category])
            ->andFilterWhere(['like', 'TranslationSource.message', $this->message])
            ->andFilterWhere(['like', 'TranslationMessage.translation', $this->translations_tmp]);

		$this->afterSearch();
		return $dataProvider;
    }
}
