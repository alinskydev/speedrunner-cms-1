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
        $lang_ids = ArrayHelper::getColumn(Yii::$app->i18n->getLanguages(true), 'id');
        return TranslationMessage::find()->andWhere(['and', ['id' => $this->id], ['in', 'language_id', $lang_ids]])->all();
    }
    
    public function translationsColumn($langs)
    {
        foreach ($this->translations as $t) {
            if ($t->translation && in_array($t->language_id, $langs)) {
                $result[] = Html::tag('b', $t->language->name) . ': ' . nl2br($t->translation);
            }
        }
        
        return isset($result) ? implode('<br>', $result) : null;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->translations_tmp) {
            foreach ($this->translations_tmp as $key => $value) {
                if ($t_msg = TranslationMessage::find()->andWhere(['counter' => $key])->one()) {
                    $t_msg->translation = $value;
                    $t_msg->save();
                }
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
