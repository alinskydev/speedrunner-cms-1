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
            ->groupBy('translation_source.id');
        
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
            'translation_source.id' => $this->id,
        ]);
        
        $query->andFilterWhere(['like', 'translation_source.category', $this->category])
            ->andFilterWhere(['like', 'translation_source.message', $this->message])
            ->andFilterWhere(['like', 'translation_message.translation', $this->translations_tmp])
            ->andFilterWhere(['like', 'IF(LENGTH(translation_message.translation) > 0, true, false)', $this->has_translation]);
        
		return $dataProvider;
    }
}
