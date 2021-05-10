<?php

namespace backend\modules\Menu\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class Menu extends ActiveRecord
{
    public $parent_id;
    
    public static function tableName()
    {
        return '{{%menu}}';
    }
    
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => \creocoder\nestedsets\NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
            ],
            'htmlTree' => [
                'class' => \wokster\treebehavior\NestedSetsTreeBehavior::className(),
                'labelAttribute' => 'name',
                'isAttributeTranslatable' => true,
            ],
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'url'],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'required', 'when' => fn ($model) => $model->isNewRecord],
            [['name', 'url'], 'string', 'max' => 100],
            
            [['parent_id'], 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'parent_id' => Yii::t('app', 'Parent'),
        ];
    }
    
    public static function find()
    {
        return new \speedrunner\db\NestedSetsQuery(get_called_class());
    }
}
