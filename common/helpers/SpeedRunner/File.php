<?php

namespace common\helpers\SpeedRunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;


class File
{
    public function save($file, $selected_dir = 'uploaded')
    {
        $dir = Yii::getAlias("@frontend/web/$selected_dir");
        FileHelper::createDirectory($dir);
        
        $file_name = strtotime('now') . '_' . Yii::$app->getSecurity()->generateRandomString(16) . ".$file->extension";
        $file->saveAs("$dir/$file_name");
        
        return "/$selected_dir/$file_name";
    }
    
    public function delete($model, $attr)
    {
        if (Yii::$app->settings->delete_model_file && $model->{$attr}) {
            $image = Yii::getAlias('@frontend/web') . $model->{$attr};
            is_file($image) ? unlink($image) : null;
        }
    }
}
