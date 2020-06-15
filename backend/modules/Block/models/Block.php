<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\db\JsonExpression;


class Block extends ActiveRecord
{
    public static function tableName()
    {
        return 'Block';
    }
    
    public function rules()
    {
        return [
            [['value'], 'string', 'when' => function ($model) {
                return in_array($model->type->type, ['textInput', 'textArea', 'CKEditor', 'ElFinder']);
            }],
            [['value'], 'boolean', 'when' => function ($model) {
                return in_array($model->type->type, ['checkbox']);
            }],
            [['value'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024], 'when' => function ($model) {
                return in_array($model->type->type, ['images']);
            }],
            [['value'], 'valueValidation', 'when' => function ($model) {
                return in_array($model->type->type, ['groups']);
            }],
        ];
    }
    
    public function valueValidation($attribute, $params, $validator)
    {
        $attrs = ArrayHelper::getColumn($this->type->attrs, 'name');
        
        foreach ($this->value as $val) {
            foreach ($val as $key => $v) {
                if (!$key || !in_array($key, $attrs)) {
                    $error_msg = Yii::t('app', 'Invalid type in {label}', ['label' => $this->type->label]);
                    $this->addError($attribute, $error_msg);
                    Yii::$app->session->setFlash('danger', $error_msg);
                }
            }
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'page_id' => Yii::t('app', 'Page'),
            'type_id' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
            'sort' => Yii::t('app', 'Sort'),
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getType()
    {
        return $this->hasOne(BlockType::className(), ['id' => 'type_id']);
    }
    
    public function afterFind()
    {
        $this->value = $this->type->has_translation ? ArrayHelper::getValue($this->value, Yii::$app->language) : $this->value;
        
        if (!$this->value && in_array($this->type->type, ['images', 'groups'])) {
            $this->value = [];
        }
        
        return parent::afterFind();
    }
    
    public function beforeValidate()
    {
        if (!$this->isNewRecord && $this->type->type == 'images' && $images = UploadedFile::getInstances($this, $this->id)) {
            $this->value = $images;
        }
        
        if ($this->type->type == 'groups' && !is_array($this->value)) {
            $this->value = [];
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        //        TRANSLATION
        
        if ($this->type->has_translation) {
            $json[Yii::$app->language] = $this->value;
            $this->value = new JsonExpression($json);
        }
        
        //        IMAGES
        
        if ($insert) {
            $this->value = in_array($this->type->type, ['images', 'groups']) ? [] : '';
        } else {
            if ($this->type->type == 'images') {
                $old_images = ArrayHelper::getValue($this->oldAttributes, 'value', []);
                
                if ($images = UploadedFile::getInstances($this, $this->id)) {
                    foreach ($images as $img) {
                        if ($this->type->has_translation) {
                            $images_arr[Yii::$app->language][] = Yii::$app->sr->image->save($img);
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
        
        //        GROUPS
        
        
        if ($this->type->type == 'groups') {
            $this->value = new JsonExpression($this->value);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterDelete()
    {
        if ($this->type->type == 'images') {
            foreach ($this->value as $v) {
                Yii::$app->sr->file->delete($v);
            }
        }
        
        return parent::afterDelete();
    }
}
