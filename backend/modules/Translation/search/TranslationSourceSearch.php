<?php

namespace backend\modules\Translation\search;

use Yii;
use yii\base\Model;

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
        
        $attribute_groups = [
            'match' => ['translation_source.id'],
            'like' => [
                'translation_source.category', 'translation_source.message',
                'translations_tmp' => 'translation_message.translation',
                'has_translation' => 'IF(LENGTH(translation_message.translation) > 0, true, false)',
            ],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
