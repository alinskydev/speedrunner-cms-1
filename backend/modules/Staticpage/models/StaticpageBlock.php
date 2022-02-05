<?php

namespace backend\modules\Staticpage\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class StaticpageBlock extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%staticpage_block}}';
    }
    
    public function prepareRules()
    {
        return [
            'value' => [
                [
                    'string',
                    'when' => fn($model) => in_array($model->input_type, ['text_input', 'text_area', 'file_manager', 'text_editor']),
                ],
                [
                    'boolean',
                    'when' => fn($model) => in_array($model->input_type, ['checkbox']),
                ],
                [
                    'each',
                    'rule' => [
                        'file',
                        'extensions' => Yii::$app->params['extensions']['image'],
                        'maxSize' => 1024 * 1024,
                    ],
                    'when' => fn($model) => in_array($model->input_type, ['files']),
                ],
                [
                    'valueValidation',
                    'when' => fn($model) => in_array($model->input_type, ['groups']),
                ],
                [
                    'default',
                    'value' => fn($model) => in_array($model->input_type, ['files', 'groups']) ? [] : '',
                ],
            ],
        ];
    }
    
    public function valueValidation($attribute, $params, $validator)
    {
        $attrs = ArrayHelper::getColumn($this->attrs, 'name');
        
        foreach ($this->value as $val) {
            foreach ($val as $key => $v) {
                if (!$key || !in_array($key, $attrs)) {
                    $error_msg = Yii::t('app', 'Invalid type in {label}', ['label' => $this->label]);
                    $this->addError($attribute, $error_msg);
                    
                    return Yii::$app->session->addFlash('danger', $error_msg);
                }
            }
        }
    }
    
    public function afterFind()
    {
        $this->value = $this->has_translation ? ArrayHelper::getValue($this->value, Yii::$app->language) : $this->value;
        
        if (!$this->value && in_array($this->input_type, ['files', 'groups'])) {
            $this->value = [];
        }
        
        return parent::afterFind();
    }
    
    public function beforeValidate()
    {
        if (!$this->isNewRecord && $this->input_type == 'files' && $files = UploadedFile::getInstances($this, $this->id)) {
            $this->value = $files;
        }
        
        if ($this->input_type == 'groups' && !is_array($this->value)) {
            $this->value = [];
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        //        Translations
        
        $lang = Yii::$app->language;
        
        if ($this->input_type == 'groups') {
            if ($this->has_translation) {
                $json = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                $json[$lang] = array_values($this->value);
                $this->value = $json;
            } else {
                $this->value = array_values($this->value);
            }
        } else {
            if ($this->has_translation) {
                $json = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                $json[$lang] = $this->value;
                $this->value = $json;
            }
        }
        
        //        Images
        
        if ($insert) {
            if (in_array($this->input_type, ['files', 'groups'])) {
                $this->value = [];
            }
        } else {
            if ($this->input_type == 'files') {
                $old_files = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                
                if ($files = UploadedFile::getInstances($this, $this->id)) {
                    foreach ($files as $f) {
                        $file_url = Yii::$app->services->file->save($f);
                        
                        if ($this->has_translation) {
                            $files_arr[$lang][] = $file_url;
                        } else {
                            $files_arr[] = $file_url;
                        }
                    }
                    
                    $this->value = ArrayHelper::merge($old_files, $files_arr);
                } else {
                    $this->value = $old_files;
                }
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterDelete()
    {
        if ($this->input_type == 'files') {
            foreach ($this->value as $v) {
                Yii::$app->services->file->delete($v);
            }
        }
        
        return parent::afterDelete();
    }
}
