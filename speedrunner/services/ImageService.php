<?php

namespace speedrunner\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use Yii\image\drivers\Image as ImageDriver;


class ImageService
{
    public static function thumb($image_url, $width_height, $type = 'crop')
    {
        $width_height_string = implode('x', $width_height);
        
        $dir = Yii::getAlias("@frontend/web/assets/thumbs/$type/$width_height_string");
        FileHelper::createDirectory($dir);
        
        $image = Yii::getAlias('@frontend/web') . $image_url;
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        
        if (is_file($image) && in_array($extension, Yii::$app->params['formats']['image'])) {
            $image_name = md5(filemtime($image) . filesize($image)) . ".$extension";
            $thumb = "$dir/$image_name";
            
            if (!is_file($thumb)) {
                $new_thumb = Yii::$app->image->load($image);
                
                switch ($type) {
                    case 'crop':
                        $new_thumb->resize($width_height[0], $width_height[1], ImageDriver::INVERSE);
                        break;
                    case 'resize':
                        $opacity = in_array($new_thumb->mime, ['image/png']) ? 0 : 100;
                        $new_thumb->resize($width_height[0], $width_height[1], ImageDriver::ADAPT);
                        $new_thumb->background('#fff', $opacity);
                        break;
                }
                
                $new_thumb->crop($width_height[0], $width_height[1]);
                $new_thumb->save($thumb, 90);
            }
            
            return str_replace(Yii::getAlias('@frontend/web'), null, $thumb);
        } else {
            return $image_url;
        }
    }
}
