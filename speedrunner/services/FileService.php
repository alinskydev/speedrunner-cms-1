<?php

namespace speedrunner\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use Yii\image\drivers\Image as ImageDriver;
use yii\web\UploadedFile;


class FileService
{
    private $file;
    
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }
    
    public function save($save_dir = 'uploaded', $width_height = [])
    {
        $save_dir .= '/' . date('Y-m-d');
        $dir = Yii::getAlias("@frontend/web/$save_dir");
        FileHelper::createDirectory($dir);
        
        $file_name = md5(strtotime('now') . Yii::$app->security->generateRandomString()) . '.' . $this->file->extension;
        
        if ($width_height) {
            $image = Yii::$app->image->load($this->file->tempName);
            
            $image->resize($width_height[0], $width_height[1], ImageDriver::ADAPT);
            $image->background('#fff', in_array($image->mime, ['image/png']) ? 0 : 100);
            $image->crop($width_height[0], $width_height[1]);
            
            $image->save("$dir/$file_name", 90);
        } else {
            $this->file->saveAs("$dir/$file_name");
        }
        
        return "/$save_dir/$file_name";
    }
    
    public static function delete($file_url)
    {
        if (Yii::$app->services->settings->delete_model_file) {
            $file_url = Yii::getAlias("@frontend/web/$file_url");
            is_file($file_url) ? unlink($file_url) : null;
        }
    }
}
