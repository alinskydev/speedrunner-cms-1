<?php

namespace backend\modules\Product\models;

use Yii;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;


class ProductSpecification extends ActiveRecord
{
    public $options_tmp;
    
    public static function tableName()
    {
        return '{{%product_specification}}';
    }
    
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name'],
            ],
            'relations_one_many' => [
                'class' => \speedrunner\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'options_tmp' => [
                        'model' => new ProductSpecificationOption(),
                        'relation' => 'options',
                        'attributes' => [
                            'main' => 'specification_id',
                            'relational' => ['name'],
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function prepareRules()
    {
        return [
            'name' => [
                ['each', 'rule' => ['required']],
                ['each', 'rule' => ['string', 'max' => 100]],
            ],
            'show_in_filter' => [
                ['boolean'],
            ],
            'show_in_compare' => [
                ['boolean'],
            ],
            'options_tmp' => [
                ['safe'],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'show_in_filter' => Yii::t('app', 'Show in filter'),
            'show_in_compare' => Yii::t('app', 'Show in compare'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            
            'options_tmp' => Yii::t('app', 'Options'),
        ];
    }
    
    public function getOptions()
    {
        return $this->hasMany(ProductSpecificationOption::className(), ['specification_id' => 'id'])->orderBy('sort');
    }
    
    public function getCategories()
    {
        return $this->hasMany(ProductCategory::className(), ['id' => 'category_id'])
            ->viaTable('product_category_specification_ref', ['specification_id' => 'id']);
    }
}
