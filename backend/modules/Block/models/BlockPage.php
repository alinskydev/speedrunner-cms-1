<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class BlockPage extends ActiveRecord
{
    public $translation_attributes = [
        'name',
    ];
    
    public $blocks_tmp;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'BlockPage';
    }
    
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
            'relations_one_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    [
                        'model' => new Block,
                        'relation' => 'blocks',
                        'attribute' => 'blocks_tmp',
                        'properties' => [
                            'main' => 'page_id',
                            'relational' => ['type_id'],
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['slug'], 'unique'],
            [['slug'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['blocks_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'blocks_tmp' => Yii::t('app', 'Blocks'),
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['page_id' => 'id'])->orderBy('sort');
    }
}
