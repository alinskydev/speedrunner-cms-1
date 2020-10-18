<?php

namespace backend\modules\System\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class SystemLanguage extends ActiveRecord
{
    public static function tableName()
    {
        return 'SystemLanguage';
    }
    
    public function rules()
    {
        return [
            [['name', 'code', 'image'], 'required'],
            [['name', 'image'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 20],
            [['weight', 'active'], 'boolean'],
            [['code'], 'unique'],
            [['code'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['weight'], 'weightValidation'],
        ];
    }
    
    public function weightValidation($attribute, $params, $validator)
    {
        if (ArrayHelper::getValue($this->oldAttributes, $attribute) && !$this->{$attribute}) {
            $this->addError($attribute, Yii::t('app', 'One of the languages must be the main'));
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'image' => Yii::t('app', 'Image'),
            'weight' => Yii::t('app', 'Main'),
            'active' => Yii::t('app', 'Active'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public function fields()
    {
        return [
            'id',
            'name',
            'code',
            'image' => function ($model) {
                return Yii::$app->urlManagerFrontend->createAbsoluteFileUrl($model->image);
            },
            'is_main' => function ($model) {
                return $model->weight;
            },
            'is_active' => function ($model) {
                return $model->active;
            },
        ];
    }
    
    static function activeItem()
    {
        return static::find()->andWhere(['weight' => 1])->asArray()->one();
    }
    
    public function beforeSave($insert)
    {
        if ($this->weight) {
            SystemLanguage::updateAll(['weight' => 0]);
            $this->active = 1;
        }
        
        $this->updated_at = date('Y-m-d H:i:s');
        
        return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if (isset($changedAttributes['active'])) {
            Yii::$app->sr->translation->fixMessages();
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function beforeDelete()
    {
        if ($this->weight) {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete main language'));
            return false;
        }
        
        return parent::beforeDelete();
    }
    
    public function afterDelete()
    {
        Yii::$app->sr->translation->fixMessages();
        
        return parent::afterDelete();
    }
}
