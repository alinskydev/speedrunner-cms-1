<?php

namespace alexantr\tinymce;

use yii\web\AssetBundle;

class WidgetAsset extends AssetBundle
{
    public $sourcePath = '@alexantr/tinymce/assets - 4.6.1';
    public $js = [
        'tinymce.min.js',
        'widget.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
