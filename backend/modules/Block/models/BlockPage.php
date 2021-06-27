<?php

namespace backend\modules\Block\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use speedrunner\validators\SlugValidator;


class BlockPage extends ActiveRecord
{
    public $blocks_tmp;
    
    public static function tableName()
    {
        return '{{%block_page}}';
    }
    
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'empty' => [],
        ]);
    }
    
    public function behaviors()
    {
        return [
            'seo_meta' => \speedrunner\behaviors\SeoMetaBehavior::className(),
            'sluggable' => \speedrunner\behaviors\SluggableBehavior::className(),
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name'],
            ],
            'relations_one_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'blocks_tmp' => [
                        'model' => new Block(),
                        'relation' => 'blocks',
                        'attributes' => [
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
            [['name'], 'string', 'max' => 100],
            [['blocks_tmp'], 'safe'],
            
            [['slug'], SlugValidator::className()],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'blocks_tmp' => Yii::t('app', 'Blocks'),
        ];
    }
    
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['page_id' => 'id'])->orderBy('sort');
    }
}
