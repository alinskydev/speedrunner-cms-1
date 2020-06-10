<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/all.min.css',
        'css/bootstrap.min.css',
        'css/bootstrap-datepicker3.min.css',
        'css/bootstrap-datetimepicker3.min.css',
        'css/select2.min.css',
        'css/jquery.toast.css',
        'css/speedrunner.css',
    ];
    
    public $js = [
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/bootstrap-datepicker.min.js',
        'js/bootstrap-datetimepicker.min.js',
        'js/select2.full.min.js',
        'js/jquery.toast.js',
        'js/speedrunner.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
