<?php

namespace frontend\assets;

use yii\web\AssetBundle;


class AppAsset extends AssetBundle
{
    public $baseUrl = '@web';
    
    public $css = [
    ];
    
    public $js = [
        'admin/js/speedrunner-ajax-triggers.js',
        'js/re-script.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
