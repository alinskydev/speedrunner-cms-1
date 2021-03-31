<?php

namespace backend\modules\Translation\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\models\TranslationMessage;
use backend\modules\System\models\SystemLanguage;


class TranslationSourceService extends ActiveService
{
    public function activeTranslations()
    {
        $languages = array_keys(SystemLanguage::find()->indexBy('code')->asArray()->all());
        $translations = ArrayHelper::index($this->model->translations, 'language');
        
        foreach ($languages as $l) {
            $result[$l] = $translations[$l] ?? new TranslationMessage(['id' => $this->model->id, 'language' => $l]);
        }
        
        return $result ?? [];
    }
    
    public static function categories()
    {
        $result = array_keys(TranslationSource::find()->indexBy('category')->asArray()->all());
        return array_combine($result, $result);
    }
}
