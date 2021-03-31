<?php

namespace backend\modules\Translation\models;

use Yii;
use speedrunner\db\ActiveRecord;

use backend\modules\System\models\SystemLanguage;


class TranslationMessage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%translation_message}}';
    }
    
    public function rules()
    {
        return [
            [['translation'], 'string'],
        ];
    }
    
    public function getSource()
    {
        return $this->hasOne(TranslationSource::className(), ['id' => 'id']);
    }
    
    public function getLang()
    {
        return $this->hasOne(SystemLanguage::className(), ['code' => 'language']);
    }
}
