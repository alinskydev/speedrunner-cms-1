<?php

namespace backend\modules\Menu\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use creocoder\nestedsets\NestedSetsBehavior;
use wokster\treebehavior\NestedSetsTreeBehavior;
use yii\db\Expression;


class Menu extends ActiveRecord
{
    public $translation_attrs = [
        'name',
        'url',
    ];
    
    public $parent_id;
    
    public static function tableName()
    {
        return 'Menu';
    }
    
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
            ],
            'htmlTree'=>[
                'class' => NestedSetsTreeBehavior::className(),
            ]
        ];
    }
    
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'url'], 'string', 'max' => 100],
            [['parent_id'], 'required', 'when' => function ($model) {
                return $model->isNewRecord;
            }],
            [['parent_id'], 'exist', 'targetClass' => self::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'expanded' => Yii::t('app', 'Expanded'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'parent_id' => Yii::t('app', 'Parent'),
        ];
    }
    
    static function itemsTree($excepts = [])
    {
        $lang = Yii::$app->language;
        
        $result = self::find()
            ->select([
                'id',
                new Expression("CONCAT(REPEAT(('- '), depth), name->>'$.$lang') as name"),
            ])
            ->where(['not in', 'id', $excepts])
            ->orderBy(['lft' => SORT_ASC, 'tree' => SORT_DESC])
            ->asArray()->all();
        
        return ArrayHelper::map($result, 'id', 'name');
    }
    
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}
