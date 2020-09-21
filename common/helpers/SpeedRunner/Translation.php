<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\db\Query;

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\models\TranslationMessage;


class Translation
{
    public function fixMessages()
    {
        $query = new Query;
        $langs = SystemLanguage::find()->select('id')->asArray()->all();
        $langs = ArrayHelper::getColumn($langs, 'id');
        
        $messages = TranslationMessage::find()->asArray()->all();
        $messages = ArrayHelper::index($messages, 'language_id', 'id');
        
        $msg_keys = ['id', 'language_id', 'translation'];
        $msg_delete = [];
        $msg_add = [];
        
        foreach ($messages as $msg_key => $msg) {
            $langs_add = $langs;
            
            foreach ($msg as $m_key => $m) {
                if (!in_array($m_key, $langs)) {
                    array_push($msg_delete, $m['counter']);
                }
                
                if (($key = array_search($m_key, $langs_add)) !== false) {
                    unset($langs_add[$key]);
                }
            }
            
            foreach ($langs_add as $l_a) {
                $msg_tmp = [$msg_key, $l_a, ''];
                array_push($msg_add, $msg_tmp);
            }
        }
        
        $query->createCommand()->batchInsert('TranslationMessage', $msg_keys, $msg_add)->execute();
        TranslationMessage::deleteAll(['counter' => $msg_delete]);
    }
}
