<?php

namespace backend\modules\Staticpage\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\db\JsonExpression;


class StaticpageBlock extends ActiveRecord
{
    public static function tableName()
    {
        return 'StaticpageBlock';
    }
    
    public function rules()
    {
        return [
            [['value'], 'string', 'when' => function ($model) {
                return in_array($model->type, ['textInput', 'textArea', 'CKEditor', 'ElFinder']);
            }],
            [['value'], 'boolean', 'when' => function ($model) {
                return in_array($model->type, ['checkbox']);
            }],
            [['value'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024], 'when' => function ($model) {
                return in_array($model->type, ['images']);
            }],
            [['value'], 'valueValidation', 'when' => function ($model) {
                return in_array($model->type, ['groups']);
            }],
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
                    Yii::$app->session->addFlash('danger', $error_msg);
                }
            }
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
    
    public function afterFind()
    {
        $this->value = $this->has_translation ? ArrayHelper::getValue($this->value, Yii::$app->language) : $this->value;
        
        if (!$this->value && in_array($this->type, ['images', 'groups'])) {
            $this->value = [];
        }
        
        return parent::afterFind();
    }
    
    public function beforeValidate()
    {
        if (!$this->isNewRecord && $this->type == 'images' && $images = UploadedFile::getInstances($this, $this->id)) {
            $this->value = $images;
        }
        
        if ($this->type == 'groups' && !is_array($this->value)) {
            $this->value = [];
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        //        TRANSLATION
        
        $lang = Yii::$app->language;
        
        if ($this->type == 'groups') {
            if ($this->has_translation) {
                $json = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                $json[$lang] = array_values($this->value);
                $this->value = new JsonExpression($json);
            } else {
                $this->value = new JsonExpression(array_values($this->value));
            }
        } else {
            if ($this->has_translation) {
                $json = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                $json[$lang] = $this->value;
                $this->value = new JsonExpression($json);
            }
        }
        
        //        IMAGES
        
        if ($insert) {
            if (in_array($this->type, ['images', 'groups'])) {
                $this->value = [];
            }
        } else {
            if ($this->type == 'images') {
                $old_images = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                
                if ($images = UploadedFile::getInstances($this, $this->id)) {
                    foreach ($images as $img) {
                        if ($this->has_translation) {
                            $images_arr[$lang][] = Yii::$app->sr->image->save($img);
                        } else {
                            $images_arr[] = Yii::$app->sr->image->save($img);
                        }
                    }
                    
                    $this->value = ArrayHelper::merge($old_images, $images_arr);
                } else {
                    $this->value = $old_images;
                }
            }
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterDelete()
    {
        if ($this->type == 'images') {
            foreach ($this->value as $v) {
                Yii::$app->sr->file->delete($v);
            }
        }
        
        return parent::afterDelete();
    }
}
