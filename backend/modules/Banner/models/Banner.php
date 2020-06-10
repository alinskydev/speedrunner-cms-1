<?php

namespace backend\modules\Banner\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class Banner extends ActiveRecord
{
    public $images_tmp;
    
    public static function tableName()
    {
        return 'Banner';
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['images_tmp'], 'safe'],
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
            'images_tmp' => Yii::t('app', 'Images'),
        ];
    }
    
    static function getLocations()
    {
        return [
            'slider_home' => Yii::t('app', 'Slider home'),
            'slider_about' => Yii::t('app', 'Slider about'),
        ];
    }
    
    public function getImages()
    {
        return $this->hasMany(BannerImage::className(), ['item_id' => 'id'])->orderBy('sort');
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        IMAGES
        
        $images = ArrayHelper::index($this->images, 'id');
        
        if ($this->images_tmp) {
            $counter = 0;
            
            foreach ($this->images_tmp as $key => $img) {
                $image_mdl = BannerImage::findOne($key) ?: new BannerImage;
                $image_mdl->item_id = $this->id;
                $image_mdl->text_1 = ArrayHelper::getValue($img, 'text_1');
                $image_mdl->text_2 = ArrayHelper::getValue($img, 'text_2');
                $image_mdl->text_3 = ArrayHelper::getValue($img, 'text_3');
                $image_mdl->link = ArrayHelper::getValue($img, 'link');
                $image_mdl->image = ArrayHelper::getValue($img, 'image');
                $image_mdl->sort = $counter;
                $image_mdl->save();
                
                ArrayHelper::remove($images, $key);
                $counter++;
            }
        }
        
        foreach ($images as $img) { $img->delete(); };
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        foreach ($this->images as $img) { $img->delete(); };
        
        return parent::afterDelete();
    }
}
