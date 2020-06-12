<?php

namespace backend\modules\Menu\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use creocoder\nestedsets\NestedSetsBehavior;
use wokster\treebehavior\NestedSetsTreeBehavior;
use backend\modules\Menu\modelsTranslation\MenuTranslation;


class Menu extends ActiveRecord
{
    public $translation_table = 'MenuTranslation';
    public $translation_attrs = [
        'name',
        'url',
    ];
    
    public $name;
    public $url;
    
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
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'tree' => Yii::t('app', 'Tree'),
            'lft' => Yii::t('app', 'Lft'),
            'rgt' => Yii::t('app', 'Rgt'),
            'depth' => Yii::t('app', 'Depth'),
            'expanded' => Yii::t('app', 'Expanded'),
            'parent_id' => Yii::t('app', 'Parent'),
        ];
    }
    
    static function getItemsList($id = 1)
    {
        $items = self::find()->orderBy(['lft' => SORT_ASC, 'tree' => SORT_DESC])->with(['translation'])->asArray()->all();
        
        foreach ($items as $item) {
            $result[$item['id']] = str_repeat('- ', $item['depth']) . $item['translation']['name'];
        }
        
        return $result;
    }
    
    public function getTranslation()
    {
        return $this->hasOne(MenuTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}
