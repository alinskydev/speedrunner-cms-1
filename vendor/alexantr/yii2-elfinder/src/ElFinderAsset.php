<?php

namespace alexantr\elfinder;

use yii\web\AssetBundle;

class ElFinderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/studio-42/elfinder';
    public $css = [
        'css/elfinder.min.css',
//        '/admin/vendor/elfinder/win10/css/theme.css',
//        '/admin/vendor/elfinder/new/css/theme.css',
        '/admin/vendor/elfinder/material/css/theme-gray.css',
    ];
    public $js = [
        'js/elfinder.min.js',
    ];
    public $publishOptions = [
        'except' => [
            'files/',
            'php/',
            '*.html',
            '*.php',
            '*.md',
            '*.json',
            'Changelog',
        ],
        'caseSensitive' => false,
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
    
    public function init()
    {
        $this->js[] = 'js/i18n/elfinder.' . \Yii::$app->language . '.js';
        
        return parent::init();
    }
}
