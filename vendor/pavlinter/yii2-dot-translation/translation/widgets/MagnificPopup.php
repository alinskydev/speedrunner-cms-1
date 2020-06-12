<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs, 2015
 * @package yii2-dot-translation
 * @version 2.1.0
 */

namespace pavlinter\translation\widgets;

use pavlinter\translation\DotMagnificAsset;
use pavlinter\translation\MagnificPopupAsset;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;


/**
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @link http://dimsemenov.com/plugins/magnific-popup/
 */
class MagnificPopup extends \yii\base\Widget
{
    /**
     * Jquery selector to which element should apply the magnific-popup.
     * @var string jQuery Selector
     */
    public $selector;

    /**
     * @var array the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is false, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'a'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * for the supported HTML attributes.
     */
    public $toggleButton = false;

    /**
     * @var $popupOptions
     */
    public $popupOptions = [];

    /**
     * @var $popupClass
     */
    public $popupClass = 'white-popup';

    /**
     * @var $popupHide
     */
    public $popupHide = 'mfp-hide';

    /**
     * @var $popupHide
     */
    public $popupAnimation = 'mfp-with-anim';

    /**
     * Options in the documentation for magnific-popup
     * @see http://dimsemenov.com/plugins/magnific-popup/documentation.html
     * @var array Magnific-Popup Option
     */
    public $pluginOptions = [];

    /**
     * @var $defaultOptions
     */
    public $defaultPluginOptions = [
        'type' => 'inline',
    ];

    /**
     * Effects in http://codepen.io/dimsemenov/pen/GAIkt
     * @var string
     * ***** LIST OF Avilable value
     * 'fade',
     * 'zoom-out',
     * 'zoom-in',
     * 'newspaper',
     * 'move-horizontal',
     * 'move-from-top',
     * '3d-unfold'
     */
    public $effect;

    /**
     * Alias for 'type' in option;
     *
     * 'ajax',
     * 'iframe',
     * 'image',
     * 'inline',
     *
     * @var $type string
     */
    public $type;

    /**
     *
     */
    public function init()
    {

        $this->initOptions();
        echo $this->renderToggleButton();
        if ($this->toggleButton !== false) {
            echo Html::beginTag('div', $this->popupOptions);
        }

        parent::init();
    }

    /**
     * Run this widget.
     * This method registers necessary javascript.
     */
    public function run()
    {
        if ($this->toggleButton !== false) {
            echo Html::endTag('div');
        }

        $this->registerScript();
    }


    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $effectList = ['fade', 'zoom-in', 'newspaper',
            'move-horizontal', 'move-from-top', '3d-unfold', 'zoom-out'
        ];

        if ($this->effect && in_array($this->effect, $effectList)) {
            $this->defaultPluginOptions['mainClass'] = 'mfp-' . $this->effect;
            $this->defaultPluginOptions['removalDelay'] = 500;
        }

        if ($this->type !== null) {
            $this->pluginOptions['type'] = $this->type;
        }

        if ($this->toggleButton !== false) {
            if (!isset($this->toggleButton['id'])) {
                $this->toggleButton['id'] = $this->getId();
            }
            if (!isset($this->popupOptions['id'])) {
                $this->popupOptions['id'] = $this->toggleButton['id'] . '-popup';
            }
            $this->selector = "#" . $this->toggleButton['id'];
            if (!isset($this->toggleButton['href'])) {
                $this->toggleButton['href'] = "#" . $this->popupOptions['id'];
            }
            $this->defaultPluginOptions['preloader'] = false;
            $this->defaultPluginOptions['overflowY'] = 'scroll';
            Html::addCssClass($this->popupOptions, $this->popupClass);
            Html::addCssClass($this->popupOptions, $this->popupHide);
            if ($this->effect) {
                Html::addCssClass($this->popupOptions, $this->popupAnimation);
            }
        }
    }

    public function registerScript()
    {
        $view = $this->getView();

        $options = ArrayHelper::merge($this->defaultPluginOptions, $this->pluginOptions);
        $js = 'jQuery("' . $this->selector . '").magnificPopup(' . Json::encode($options) . ');';

        DotMagnificAsset::register($view);
        MagnificPopupAsset::register($view);
        $view->registerJs($js);
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'a');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($toggleButton['type'])) {
                $toggleButton['type'] = 'button';
            }
            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }
}
