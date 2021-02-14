<?php

namespace backend\modules\Translation\models;

use Yii;
use speedrunner\db\ActiveRecord;

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
    
    public function getLang()
    {
        return $this->hasOne(SystemLanguage::className(), ['code' => 'language']);
    }
}
