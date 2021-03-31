<?php

namespace backend\modules\Translation\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\modules\Translation\models\TranslationSource;
use backend\modules\Translation\services\TranslationSourceService;


class TranslationImportForm extends Model
{
    public $category;
    public $file;
    
    public $available_categories;
    
    public function init()
    {
        $this->available_categories = TranslationSourceService::categories();
        return parent::init();
    }
    
    public function rules()
    {
        return [
            [['category', 'file'], 'required'],
            [['category'], 'in', 'range' => array_keys($this->available_categories)],
            [['file'], 'file', 'extensions' => ['json'], 'maxSize' => 1024 * 1024],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'category' => Yii::t('app', 'Category'),
            'file' => Yii::t('app', 'File'),
        ];
    }
    
    public function beforeValidate()
    {
        if ($file = UploadedFile::getInstance($this, 'file')) {
            $this->file = $file;
        }
        
        return parent::beforeValidate();
    }
    
    public function import()
    {
        $data = file_get_contents($this->file->tempName);
        $data = json_decode($data, true);
        
        $sources = TranslationSource::find()
            ->andWhere([
                'category' => $this->category,
                'message' => array_keys($data),
            ])
            ->indexBy('message')
            ->all();
        
        foreach ($sources as $message => $source) {
            $source->translations_tmp = ArrayHelper::getValue($data, $message);
            $source->save();
        }
        
        return true;
    }
}
