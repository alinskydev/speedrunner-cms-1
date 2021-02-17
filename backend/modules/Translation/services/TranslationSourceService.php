<?php

namespace backend\modules\Translation\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;

use backend\modules\Translation\models\TranslationMessage;


class TranslationSourceService extends ActiveService
{
    public function activeTranslations()
    {
        $langs = array_keys(Yii::$app->services->i18n::$languages);
        $translations = ArrayHelper::index($this->model->translations, 'language');
        
        foreach ($langs as $l) {
            $result[$l] = $translations[$l] ?? new TranslationMessage(['id' => $this->model->id, 'language' => $l]);
        }
        
        return $result ?? [];
    }
}
