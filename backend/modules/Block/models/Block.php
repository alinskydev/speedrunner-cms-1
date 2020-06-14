<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\db\JsonExpression;


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
    
    public function getImages()
    {
        return $this->hasMany(BlockImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function afterFind()
    {
        $this->value = $this->type->has_translation ? ArrayHelper::getValue($this->value, Yii::$app->language) : $this->value;
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
            $this->value = [];
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        if ($this->type->has_translation) {
            if ($json = ArrayHelper::getValue($this->oldAttributes, 'value')) {
                $json[Yii::$app->language] = $this->value;
            } else {
                $langs = Yii::$app->i18n->getLanguages(true);
                
                foreach ($langs as $l) {
                    $json[$l['code']] = $this->value;
                } 
            }
            
            $this->value = new JsonExpression($json);
        }
        
        if ($this->type == 'groups') {
            $this->value = new JsonExpression($this->value);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($images_tmp = UploadedFile::getInstances($this, $this->id)) {
            Yii::$app->sr->image->save($images_tmp, new BlockImage(['item_id' => $this->id]));
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
