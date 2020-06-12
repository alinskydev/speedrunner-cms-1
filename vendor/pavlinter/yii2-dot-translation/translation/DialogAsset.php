<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs, 2015
 * @package yii2-dot-translation
 * @version 2.1.0
 */

namespace pavlinter\translation;

/**
 * @author Pavels Radajevs <pavlinter@gmail.com>
 */
class DialogAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@vendor/pavlinter/yii2-dot-translation/translation/assets';

    public $css = [
        'css/dialog.css',
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}