<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use Yii\image\drivers\Image as ImageDriver;


class File
{
    public function save($file, $save_dir = 'uploaded', $width_height = [])
    {
        $save_dir .= '/' . date('Y-m-d');
        $dir = Yii::getAlias("@frontend/web/$save_dir");
        FileHelper::createDirectory($dir);
        
        $file_name = md5(strtotime('now') . Yii::$app->security->generateRandomString(16)) . ".$file->extension";
        
        if ($width_height) {
            $image = Yii::$app->image->load($file->tempName);
            
            $image->resize($width_height[0], $width_height[1], ImageDriver::ADAPT);
            $image->background('#fff', in_array($image->mime, ['image/png']) ? 0 : 100);
            $image->crop($width_height[0], $width_height[1]);
            
            $image->save("$dir/$file_name", 90);
        } else {
            $file->saveAs("$dir/$file_name");
        }
        
        return "/$save_dir/$file_name";
    }
    
    public function delete($file)
    {
        if (Yii::$app->settings->delete_model_file) {
            $file = Yii::getAlias("@frontend/web/$file");
            is_file($file) ? unlink($file) : null;
        }
    }
}
