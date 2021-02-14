<?php

namespace backend\modules\Translation\services;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\models\TranslationMessage;


class TranslationSourceService
{
    private $model;
    
    public function __construct(TranslationSource $model)
    {
        $this->model = $model;
    }
    
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
