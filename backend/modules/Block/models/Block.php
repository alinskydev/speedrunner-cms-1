<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\modules\Block\modelsTranslation\BlockTranslation;


class Block extends ActiveRecord
{
    public $images_tmp;
    
    public static function tableName()
    {
        return 'Block';
    }
    
    public function rules()
    {
        return [
            [['type_id', 'sort'], 'required'],
            [['sort'], 'integer'],
            [['type_id'], 'exist', 'targetClass' => BlockType::className(), 'targetAttribute' => 'id'],
            [['value'], 'string', 'when' => function ($model) {
                return in_array($model->type->type, ['textInput', 'textArea', 'CKEditor', 'ElFinder']);
            }],
            [['value'], 'boolean', 'when' => function ($model) {
                return in_array($model->type->type, ['checkbox']);
            }],
            [['value'], 'valueValidation', 'when' => function ($model) {
                return in_array($model->type->type, ['groups']);
            }],
            [['images_tmp'], 'each', 'rule' => ['file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024]],
        ];
    }
    
    public function valueValidation($attribute, $params, $validator)
    {
        $attrs = json_decode($this->type->attrs, JSON_UNESCAPED_UNICODE);
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
            'page_id' => Yii::t('app', 'Page'),
            'type_id' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
            'sort' => Yii::t('app', 'Sort'),
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(BlockTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getType()
    {
        return $this->hasOne(BlockType::className(), ['id' => 'type_id']);
    }
    
    public function getImages()
    {
        return $this->hasMany(BlockImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function afterFind()
    {
        if (isset($this->translation)) {
            $this->value = $this->type->has_translation ? $this->translation->value : $this->value;
        }
        
        if ($this->type->type == 'groups') {
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
        
        if ($this->type->type == 'groups' && !is_array($this->value)) {
            $this->value = null;
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        if ($this->type->type == 'groups') {
            $this->value = json_encode($this->value, JSON_UNESCAPED_UNICODE);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        IMAGES
        
        if ($images_tmp = UploadedFile::getInstances($this, $this->id)) {
            Yii::$app->sr->image->save($images_tmp, new BlockImage(['item_id' => $this->id]));
        }
        
        //        TRANSLATION
        
        if ($this->type->has_translation) {
            $translation_mdl = $this->translation ?: new BlockTranslation;
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
        
        BlockTranslation::deleteAll(['item_id' => $this->id]);
        
        return parent::afterDelete();
    }
}
