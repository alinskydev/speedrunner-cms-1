<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;


class AppAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $css = [
        'css/all.min.css',
        'css/bootstrap.min.css',
        'css/bootstrap-datetimepicker.min.css',
        'css/select2.min.css',
        'css/jquery.toast.css',
        
        'css/speedrunner.css',
    ];
    
    public $js = [
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/bootstrap-datetimepicker.min.js',
        'js/select2.full.min.js',
        'js/jquery.toast.js',
        
        'js/speedrunner-triggers.js',
        'js/speedrunner-ajax-triggers.js',
        'js/speedrunner.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    
    public function init()
    {
        $this->css[] = 'css/design/fonts/' . ArrayHelper::getValue(Yii::$app->user->identity, 'design_font', 'roboto') . '.css';
        
        return parent::init();
    }
}
