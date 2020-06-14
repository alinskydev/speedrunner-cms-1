<?php

namespace backend\modules\StaticPage\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\db\JsonExpression;


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
        $attrs = ArrayHelper::getColumn($this->attrs, 'name');
        
        foreach ($this->value as $val) {
            foreach ($val as $key => $v) {
                if (!$key || !in_array($key, $attrs)) {
                    $error_msg = Yii::t('app', 'Invalid type in {label}', ['label' => $this->label]);
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
    
    public function getImages()
    {
        return $this->hasMany(StaticPageBlockImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function afterFind()
    {
        $this->value = $this->has_translation ? ArrayHelper::getValue($this->value, Yii::$app->language) : $this->value;
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
            $this->value = [];
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave($insert)
    {
        if ($this->has_translation) {
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
            Yii::$app->sr->image->save($images_tmp, new StaticPageBlockImage(['item_id' => $this->id]));
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
