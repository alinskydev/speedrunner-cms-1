<?php

namespace speedrunner\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;

use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;


class ImageHelper
{
    public static function thumb($image_url, $width_height, $type = 'resize')
    {
        $width_height_string = implode('x', $width_height);
        
        $dir = Yii::getAlias("@frontend/web/assets/thumbs/$type/$width_height_string");
        FileHelper::createDirectory($dir);
        
        $image = Yii::getAlias('@frontend/web') . $image_url;
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        
        if (!is_file($image)) {
            return Yii::$app->services->settings->image_placeholder;
        }
        
        if (in_array($extension, Yii::$app->params['extensions']['image'])) {
            $image_name = md5(filemtime($image) . filesize($image)) . ".$extension";
            $thumb = "$dir/$image_name";
            
            if (!is_file($thumb)) {
                $new_thumb = new Image();
                $new_thumb::$thumbnailBackgroundAlpha = 0;
                
                switch ($type) {
                    case 'resize':
                        $new_thumb = $new_thumb->thumbnail($image, $width_height[0], $width_height[1], ManipulatorInterface::THUMBNAIL_INSET);
                        break;
                    case 'crop':
                        $new_thumb = $new_thumb->thumbnail($image, $width_height[0], $width_height[1], ManipulatorInterface::THUMBNAIL_OUTBOUND);
                        break;
                }
                
                $new_thumb->save($thumb, ['quality' => 100]);
            }
            
            return str_replace(Yii::getAlias('@frontend/web'), null, $thumb);
        } else {
            return $image_url;
        }
    }
    
    public static function sourceTag($image_url, $width_height = null, $thumb_type = 'resize', $options = [])
    {
        if ($width_height) {
            $image_url = self::thumb($image_url, $width_height, $thumb_type);
        }
        
        $image = Yii::getAlias('@frontend/web') . $image_url;
        
        if (!is_file($image)) {
            return false;
        }
        
        $image_mime_type = mime_content_type($image);
        
        if (in_array($image_mime_type, ['image/png', 'image/jpeg'])) {
            $dir = Yii::getAlias('@frontend/web/assets/thumbs/webp');
            FileHelper::createDirectory($dir);
            
            $image_name = md5(filemtime($image) . filesize($image)) . '.webp';
            $source_image = "$dir/$image_name";
            
            if (!is_file($source_image)) {
                switch ($image_mime_type) {
                    case 'image/png':
                        $image = imagecreatefrompng($image);
		        	    imagepalettetotruecolor($image);
		        	    imagealphablending($image, true);
		        	    imagesavealpha($image, true);
                        break;
                        
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($image);
		        	    imagepalettetotruecolor($image);
                        break;
                }
                
                imagewebp($image, $source_image);
            }
            
            $source_image = str_replace(Yii::getAlias('@frontend/web'), null, $source_image);
        } else {
            $source_image = $image_url;
        }
        
        return Html::tag('source', null, ArrayHelper::merge([
            'srcset' => $source_image,
            'type' => mime_content_type(Yii::getAlias("@frontend/web/$source_image")),
        ], $options));
    }
}
