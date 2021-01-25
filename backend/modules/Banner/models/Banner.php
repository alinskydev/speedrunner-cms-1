<?php

namespace backend\modules\Banner\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Banner extends ActiveRecord
{
    public $groups_tmp;
    
    public static function tableName()
    {
        return 'Banner';
    }
    
    public function behaviors()
    {
        return [
            'relations_one_many' => [
                'class' => \common\behaviors\RelationBehavior::className(),
                'type' => 'oneMany',
                'attributes' => [
                    'groups_tmp' => [
                        'model' => new BannerGroup(),
                        'relation' => 'groups',
                        'attributes' => [
                            'main' => 'item_id',
                            'relational' => ['text_1', 'text_2', 'text_3', 'link', 'image'],
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
            [['groups_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'location' => Yii::t('app', 'Location'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'groups_tmp' => Yii::t('app', 'Groups'),
        ];
    }
    
    public static function locations()
    {
        return [
            'slider_home' => [
                'label' => Yii::t('app', 'Slider home'),
            ],
            'slider_about' => [
                'label' => Yii::t('app', 'Slider about'),
            ],
        ];
    }
    
    public function getGroups()
    {
        return $this->hasMany(BannerGroup::className(), ['item_id' => 'id'])->orderBy('sort');
    }
}
