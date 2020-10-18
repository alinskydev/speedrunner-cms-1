<?php

namespace backend\modules\Translation\models;

use Yii;
use common\components\framework\ActiveRecord;

use backend\modules\System\models\SystemLanguage;


class TranslationMessage extends ActiveRecord
{
    public static function tableName()
    {
        return 'TranslationMessage';
    }
    
    public function rules()
    {
        return [
            [['translation'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'language_id' => Yii::t('app', 'Language'),
            'translation' => Yii::t('app', 'Translation'),
        ];
    }
    
    public function getLanguage()
    {
        return $this->hasOne(SystemLanguage::className(), ['id' => 'language_id']);
    }
}
