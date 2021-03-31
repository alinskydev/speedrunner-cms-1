<?php

namespace speedrunner\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use Yii\image\drivers\Image as ImageDriver;
use yii\web\UploadedFile;


class FileService
{
    private $base_dir;
    
    public function __construct()
    {
        $this->base_dir = Yii::getAlias("@frontend/web");
    }
    
    public function save(UploadedFile $file, $save_dir = 'uploaded', $width_height = [])
    {
        $save_dir .= '/' . date('Y-m-d');
        $dir = "$this->base_dir/$save_dir";
        FileHelper::createDirectory($dir);
        
        $file_name = md5(strtotime('now') . Yii::$app->security->generateRandomString()) . '.' . $file->extension;
        
        if ($width_height) {
            $image = Yii::$app->image->load($file->tempName);
            
            $image->resize($width_height[0], $width_height[1], ImageDriver::ADAPT);
            $image->background('#fff', in_array($image->mime, ['image/png']) ? 0 : 100);
            $image->crop($width_height[0], $width_height[1]);
            
            $image->save("$dir/$file_name", 100);
        } else {
            $file->saveAs("$dir/$file_name");
        }
        
        return "/$save_dir/$file_name";
    }
    
    public function duplicate($file_url, $save_dir)
    {
        $file_url = Yii::getAlias("@frontend/web/$file_url");
        
        if (is_file($file_url)) {
            $extension = pathinfo($file_url)['extension'];
            
            $save_dir .= '/' . date('Y-m-d');
            $dir = "$this->base_dir/$save_dir";
            FileHelper::createDirectory($dir);
            
            $file_name = md5(strtotime('now') . Yii::$app->security->generateRandomString()) . '.' . $extension;
            
            copy($file_url, "$dir/$file_name");
            return "/$save_dir/$file_name";
        }
    }
    
    public function delete($file_url)
    {
        if (Yii::$app->services->settings->delete_model_file) {
            $file_url = "$this->base_dir/$file_url";
            is_file($file_url) ? unlink($file_url) : null;
        }
    }
}
