<?php

namespace backend\modules\StaticPage\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\modules\StaticPage\modelsTranslation\StaticPageBlockTranslation;


class StaticPageBlock extends ActiveRecord
{
    public $images_tmp;
    
    public static function tableName()
    {
        return 'StaticPageBlock';
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
            [['value'], 'valueValidation', 'when' => function ($model) {
                return in_array($model->type, ['groups']);
            }],
            [['images_tmp'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function valueValidation($attribute, $params, $validator)
    {
        $attrs = json_decode($this->attrs, JSON_UNESCAPED_UNICODE);
        $attrs = ArrayHelper::getColumn($attrs, 'name');
        
        foreach ($this->{$attribute} as $attr) {
            foreach ($attr as $key => $a) {
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
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(StaticPageBlockTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getImages()
    {
        return $this->hasMany(StaticPageBlockImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function afterFind()
    {
        if (isset($this->translation)) {
            $this->value = $this->has_translation ? $this->translation->value : $this->value;
        }
        
        if ($this->type == 'groups') {
            $this->value = json_decode($this->value, JSON_UNESCAPED_UNICODE) ?: [];
        }
        
        return parent::afterFind();
    }
    
    public function beforeValidate()
    {
        if (!$this->isNewRecord) {
            if ($images_tmp = UploadedFile::getInstances($this, $this->id)) {
                $this->images_tmp = $images_tmp;
            }
        }
        
        if ($this->type == 'groups' && !is_array($this->value)) {
            $this->value = null;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        if ($this->type == 'groups') {
            $this->value = json_encode($this->value, JSON_UNESCAPED_UNICODE);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        IMAGES
        
        if ($images_tmp = UploadedFile::getInstances($this, $this->id)) {
            Yii::$app->sr->image->save($images_tmp, new StaticPageBlockImage(['item_id' => $this->id]));
        }
        
        //        TRANSLATION
        
        if ($this->has_translation) {
            $translation_mdl = $this->translation ?: new StaticPageBlockTranslation;
            $translation_mdl->item_id = $this->id;
            $translation_mdl->lang = Yii::$app->language;
            $translation_mdl->value = $this->value;
            $translation_mdl->save();
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        foreach ($this->images as $img) { $img->delete(); };
        
        StaticPageBlockTranslation::deleteAll(['item_id' => $this->id]);
        
        return parent::afterDelete();
    }
}
