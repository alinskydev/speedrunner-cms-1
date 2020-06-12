<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs, 2015
 * @package yii2-dot-translation
 * @version 2.1.0
 */

namespace pavlinter\translation;

/**
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @link http://dimsemenov.com/plugins/magnific-popup/
 */
class MagnificPopupAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@bower/magnific-popup/dist';

    public $js = [
        'jquery.magnific-popup.min.js',
    ];

    public $css = [
        'magnific-popup.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}