<?php

namespace backend\modules\System\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use speedrunner\validators\SlugValidator;


class SystemLanguage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%system_language}}';
    }
    
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => \speedrunner\behaviors\CacheBehavior::className(),
                'tags' => ['active_system_languages'],
            ],
        ];
    }
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'code' => [
                ['required'],
                [SlugValidator::className(), 'max' => 20],
            ],
            'image' => [
                ['required'],
                ['string', 'max' => 100],
            ],
            'is_active' => [
                ['boolean'],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'image' => Yii::t('app', 'Image'),
            'is_active' => Yii::t('app', 'Active'),
            'is_main' => Yii::t('app', 'Main'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if ($this->is_main) {
            $this->is_active = 1;
            self::updateAll(['is_main' => 0], ['!=', 'id', $this->id]);
        }
        
        return parent::beforeSave($insert);
    }
    
    public function beforeDelete()
    {
        if ($this->is_main) {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete main language'));
            return false;
        }
        
        return parent::beforeDelete();
    }
}
