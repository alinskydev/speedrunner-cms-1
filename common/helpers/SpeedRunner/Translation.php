<?php

namespace common\helpers\SpeedRunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\db\Query;

use backend\modules\System\models\SystemLanguage;
use backend\modules\System\models\TranslationMessage;


class Translation
{
    public function set($model, $insert)
    {
        $query = new Query;
        
        foreach ($model->translation_attrs as $t_a) {
            $params[$t_a] = $model->{$t_a};
        }
        
        if ($model->translation || isset($model['attributes']['tree'])) {
            $query->createCommand()->update($model->translation_table, $params, ['item_id' => $model->id, 'lang' => Yii::$app->language])->execute();
        } elseif ($insert) {
            $langs = SystemLanguage::getItemsList();
            
            foreach ($langs as $l) {
                $params['item_id'] = $model->id;
                $params['lang'] = $l['code'];
                $params_keys = array_keys($params);
                $params_values = array_values($params);
                
                $query->createCommand()->batchInsert($model->translation_table, $params_keys, [$params_values])->execute();
            }
        } else {
            $params['item_id'] = $model->id;
            $params['lang'] = Yii::$app->language;
            $params_keys = array_keys($params);
            $params_values = array_values($params);
            
            $query->createCommand()->batchInsert($model->translation_table, $params_keys, [$params_values])->execute();
        }
    }
    
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
