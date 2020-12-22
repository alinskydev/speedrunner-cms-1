<?php

namespace backend\modules\Menu\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


class Menu extends ActiveRecord
{
    public $parent_id;
    
    public static function tableName()
    {
        return 'Menu';
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
            ],
            'translation' => [
                'class' => \common\behaviors\TranslationBehavior::className(),
                'attributes' => ['name', 'url'],
            ],
        ];
    }
    
    public function transactions()
    {
        return [
            static::SCENARIO_DEFAULT => static::OP_ALL,
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'url'], 'string', 'max' => 100],
            [['parent_id'], 'required', 'when' => fn ($model) => $model->isNewRecord],
            
            [['parent_id'], 'exist', 'targetClass' => static::className(), 'targetAttribute' => 'id'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
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
        
        $result = static::find()
            ->select([
                'id',
                new Expression("CONCAT(REPEAT(('- '), (depth - 1)), name->>'$.$lang') as name"),
            ])
            ->andWhere(['not in', 'id', $excepts])
            ->orderBy(['lft' => SORT_ASC, 'tree' => SORT_DESC])
            ->asArray()->all();
        
        return ArrayHelper::map($result, 'id', 'name');
    }
    
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
}
