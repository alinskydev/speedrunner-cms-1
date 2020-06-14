<?php

namespace backend\modules\Banner\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Banner extends ActiveRecord
{
    public $groups_tmp;
    
    public static function tableName()
    {
        return 'Banner';
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
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'location' => Yii::t('app', 'Location'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'groups_tmp' => Yii::t('app', 'Groups'),
        ];
    }
    
    static function getLocations()
    {
        return [
            'slider_home' => Yii::t('app', 'Slider home'),
            'slider_about' => Yii::t('app', 'Slider about'),
        ];
    }
    
    public function getGroups()
    {
        return $this->hasMany(BannerGroup::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        GROUPS
        
        $groups = ArrayHelper::index($this->groups, 'id');
        
        if ($this->groups_tmp) {
            $counter = 0;
            
            foreach ($this->groups_tmp as $key => $g) {
                $group_mdl = BannerGroup::findOne($key) ?: new BannerGroup;
                $group_mdl->item_id = $this->id;
                $group_mdl->text_1 = ArrayHelper::getValue($g, 'text_1');
                $group_mdl->text_2 = ArrayHelper::getValue($g, 'text_2');
                $group_mdl->text_3 = ArrayHelper::getValue($g, 'text_3');
                $group_mdl->link = ArrayHelper::getValue($g, 'link');
                $group_mdl->image = ArrayHelper::getValue($g, 'image');
                $group_mdl->sort = $counter;
                $group_mdl->save();
                
                ArrayHelper::remove($groups, $key);
                $counter++;
            }
        }
        
        foreach ($groups as $g) { $g->delete(); };
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
