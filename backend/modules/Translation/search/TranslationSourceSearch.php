<?php

namespace backend\modules\Translation\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Translation\models\TranslationSource;


class TranslationSourceSearch extends TranslationSource
{
    public $has_translation;
    
    public function rules()
    {
        return [
            [['id', 'has_translation'], 'integer'],
            [['category', 'message', 'translations_tmp'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = TranslationSource::find()
            ->joinWith(['currentTranslation'])
            ->groupBy('TranslationSource.id');
        
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
            'TranslationSource.id' => $this->id,
        ]);
        
        $query->andFilterWhere(['like', 'TranslationSource.category', $this->category])
            ->andFilterWhere(['like', 'TranslationSource.message', $this->message])
            ->andFilterWhere(['like', 'TranslationMessage.translation', $this->translations_tmp])
            ->andFilterWhere(['like', 'IF(LENGTH(TranslationMessage.translation) > 0, true, false)', $this->has_translation]);
        
		return $dataProvider;
    }
}
