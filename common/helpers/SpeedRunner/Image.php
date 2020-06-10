<?php

namespace common\helpers\SpeedRunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use Yii\image\drivers\Image as ImageDriver;


class Image
{
    public function save($images, $model = null, $width_height = [], $selected_dir = 'uploaded')
    {
        $dir = Yii::getAlias("@frontend/web/$selected_dir");
        FileHelper::createDirectory($dir);
        
        foreach ($images as $key => $img) {
            $image_name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(16) . ".$img->extension";
            $image = Yii::$app->image->load($img->tempName);
            
            if ($width_height) {
                $opacity = in_array($image->mime, ['image/png']) ? 0 : 100;
                $image->resize($width_height[0], $width_height[1], ImageDriver::ADAPT);
                $image->background('#fff', $opacity);
                $image->crop($width_height[0], $width_height[1]);
            }
            
            $image->save("$dir/$image_name", 90);
            
            if ($model) {
                $image_mdl = clone($model);
                $image_mdl->image = "/$selected_dir/$image_name";
                $image_mdl->sort = $key;
                $image_mdl->save();
            } else {
                return "/$selected_dir/$image_name";
            }
        }
    }
    
    public function thumb($image_url, $width_height, $type = 'crop')
    {
        $width_height_string = implode('x', $width_height);
        
        $dir = Yii::getAlias('@frontend/web/assets/thumbs');
        FileHelper::createDirectory("$dir/$width_height_string");
        
        $image = Yii::getAlias('@frontend/web') . $image_url;
        
        if (is_file($image) && getimagesize($image)) {
            $image_name = filemtime($image) . filesize($image) . '.' . pathinfo($image, PATHINFO_EXTENSION);
            $thumb = "$dir/$width_height_string/$image_name";
            
            if (!is_file($thumb)) {
                $new_thumb = Yii::$app->image->load($image);
                
                switch ($type) {
                    case 'resize':
                        $opacity = in_array($new_thumb->mime, ['image/png']) ? 0 : 100;
                        $new_thumb->resize($width_height[0], $width_height[1], ImageDriver::ADAPT);
                        $new_thumb->background('#fff', $opacity);
                        break;
                    case 'crop':
                        $new_thumb->resize($width_height[0], $width_height[1], ImageDriver::INVERSE);
                        break;
                }
                
                $new_thumb->crop($width_height[0], $width_height[1]);
                $new_thumb->save($thumb, 90);
            }
            
            return str_replace(Yii::getAlias('@frontend/web'), '', $thumb);
        } else {
            return $image_url;
        }
    }
}
