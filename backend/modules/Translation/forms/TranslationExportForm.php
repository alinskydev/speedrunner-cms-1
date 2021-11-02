<?php

namespace backend\modules\Translation\forms;

use Yii;
use speedrunner\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\services\TranslationSourceService;
use backend\modules\System\models\SystemLanguage;


class TranslationExportForm extends Model
{
    public $category;
    public $languages;
    
    public $available_categories;
    public $available_languages;
    
    public function init()
    {
        $this->available_categories = TranslationSourceService::categories();
        $this->available_languages = ArrayHelper::map(SystemLanguage::find()->indexBy('code')->asArray()->all(), 'code', 'name');
        
        return parent::init();
    }
    
    public function prepareRules()
    {
        return [
            'category' => [
                ['required'],
                ['in', 'range' => array_keys($this->available_categories)],
            ],
            'languages' => [
                ['required'],
                ['in', 'range' => array_keys($this->available_languages), 'allowArray' => true],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'category' => Yii::t('app', 'Category'),
            'languages' => Yii::t('app', 'Languages'),
        ];
    }
    
    public function export()
    {
        $sources = TranslationSource::find()
            ->joinWith(['translations'])
            ->andWhere([
                'translation_source.category' => $this->category,
            ])
            ->asArray()->all();
        
        $data = ArrayHelper::map($sources, 'message', function($value) {
            return ArrayHelper::map($value['translations'], 'language', 'translation');
        });
        
        foreach ($data as &$message) {
            $message = ArrayHelper::filter($message, $this->languages);
            
            foreach ($this->languages as $language) {
                $message[$language] = $message[$language] ?? '';
            }
        }
        
        $file = tempnam(sys_get_temp_dir(), 'json');
        file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        
        header('Content-Type: text/plain');
        header("Content-Disposition: attachment; filename=Translations-$this->category.json");
        readfile($file);
        unlink($file);
        
        die;
    }
}
