<?php

namespace backend\modules\System\models;

use Yii;
use common\components\framework\ActiveRecord;


class TranslationMessage extends ActiveRecord
{
    public static function tableName()
    {
        return 'TranslationMessage';
    }
    
    public function rules()
    {
        return [
            [['id', 'language_id'], 'required'],
            [['translation'], 'string'],
            [['language_id'], 'exist', 'targetClass' => SystemLanguage::className(), 'targetAttribute' => 'id'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TranslationSource::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language_id' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }
    
    public function getId()
    {
        return $this->hasOne(translationSource::className(), ['id' => 'id']);
    }
    
    public function getLanguage()
    {
        return $this->hasOne(SystemLanguage::className(), ['id' => 'language_id']);
    }
}
