<?php

namespace backend\modules\Translation\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\Html;
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
            'id' => Yii::t('app', 'Id'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
            'translations_tmp' => Yii::t('app', 'Translations'),
        ];
    }
    
    public function getTranslations()
    {
        return $this->hasMany(TranslationMessage::className(), ['id' => 'id']);
    }
    
    public function activeTranslations()
    {
        $langs = array_keys(Yii::$app->sr->translation->languages);
        $messages = TranslationMessage::find()->andWhere(['id' => $this->id, 'language' => $langs])->indexBy('language')->all();
        
        foreach ($langs as $l) {
            $messages[$l] = $messages[$l] ?? new TranslationMessage(['id' => $this->id, 'language' => $l]);
        }
        
        return $messages;
    }
    
    public function translationsColumn()
    {
        foreach ($this->translations as $t) {
            if ($t->translation && ArrayHelper::getValue($t, 'lang.is_active')) {
                $result[] = Html::tag('b', $t->lang->name) . ': ' . nl2br($t->translation);
            }
        }
        
        return implode('<br>', $result ?? []);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->translations_tmp) {
            $available_langs = Yii::$app->sr->translation->languages;
            
            foreach ($this->translations_tmp as $key => $value) {
                if (array_key_exists($key, $available_langs)) {
                    $relation_mdl = TranslationMessage::find()->andWhere(['id' => $this->id, 'language' => $key])->one() ?: new TranslationMessage;
                    $relation_mdl->id = $this->id;
                    $relation_mdl->language = $key;
                    $relation_mdl->translation = $value;
                    $relation_mdl->save();
                }
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
