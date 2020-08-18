<?php

namespace backend\modules\System\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class TranslationSource extends ActiveRecord
{
    public $translations_tmp;
    
    public static function tableName()
    {
        return 'TranslationSource';
    }
    
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32],
            [['translations_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
            'translations_tmp' => Yii::t('app', 'Translations'),
        ];
    }
    
    public function getTranslations()
    {
        return $this->hasMany(TranslationMessage::className(), ['id' => 'id']);
    }
    
    public function getActiveTranslations($langs)
    {
        return $this->hasMany(TranslationMessage::className(), ['id' => 'id'])->andWhere(['in', 'language_id', $langs])->all();
    }
    
    public function getTranslationsColumn($langs)
    {
        $result = [];
        
        foreach ($this->translations as $t) {
            if ($t->translation && in_array($t->language_id, $langs)) {
                $result[] = '<b>' . $t->language->name . '</b>: ' . nl2br($t->translation);
            }
        }
        
        return implode('<br>', $result);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->translations_tmp) {
            foreach ($this->translations_tmp as $key => $t_t) {
                $t_msg = TranslationMessage::find()->where(['counter' => $key])->one();
                $t_msg->translation = $t_t;
                $t_msg->save();
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        TranslationMessage::deleteAll(['id' => $this->id]);
        
        return parent::afterDelete();
    }
}
