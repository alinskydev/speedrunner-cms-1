<?php

namespace zxbodya\yii2\elfinder;

use Yii;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;
use zxbodya\yii2\elfinder\ElFinderAsset;


class ElFinderInput extends InputWidget
{
    /**
     * Client settings.
     * More about this: https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
     * @var array
     */
    public $settings = array();
    public $connectorRoute = false;
    public $id;
    public $inputOptions = [];
    
    
    public function init()
    {
        if (empty($this->connectorRoute)) {
            throw new Exception('$connectorRoute must be set!');
        }
        $this->settings['url'] = Url::toRoute($this->connectorRoute);
        $this->settings['lang'] = Yii::$app->language;
    }

    public function run()
    {
        $this->options['id'] = $this->id ?: 'elfinder-' . $this->attribute;
        $this->options['class'] = ArrayHelper::getValue($this->options, 'custom_class', 'elfinder-container');

        $contoptions = $this->options;
        $contoptions['id'] = $this->options['id'] . 'container';
        echo Html::beginTag('div', $contoptions);
        $inputOptions = ArrayHelper::merge([
            'id' => $this->options['id'], 'style' => 'float:left; display:none;', 'name' => $this->name
        ], $this->inputOptions);
        
        //      IMAGE DISPLAY
        
        if (isset($this->value)) {
            $value = $this->value;
        } elseif ($this->model) {
            $value = $this->model->{$this->attribute};
        } else {
            $value = null;
        }
        
        $file_path = Yii::getAlias('@frontend/web') . $value;
        $file_mime_type = is_file($file_path) ? FileHelper::getMimeType($file_path) : '';
        
        if (strpos($file_mime_type, 'image') !== false) {
            if (strpos($file_mime_type, 'icon') === false) {
                $file_url = $value ? Yii::$app->services->image->thumb($value, [100, 100], 'resize') : '';
                $html = Html::img($file_url, ['class' => 'preview-elfinder preview-' . $this->options['id']]);
            } else {
                $file_url = $value;
                $html = Html::img($file_url, ['class' => 'preview-elfinder preview-' . $this->options['id']]);
            }
        }
        
        if (strpos($file_mime_type, 'audio') !== false) {
            $file_url = $value;
            $source_tag = Html::tag('source', '', ['src' => $file_url]);
            $html = Html::tag('audio', $source_tag, ['class' => 'preview-elfinder preview-' . $this->options['id'], 'controls' => true]);
        }
        
        if (strpos($file_mime_type, 'video') !== false) {
            $file_url = $value;
            $source_tag = Html::tag('source', '', ['src' => $file_url]);
            $html = Html::tag('video', $source_tag, ['class' => 'preview-elfinder preview-' . $this->options['id'], 'controls' => true]);
        }
        
        if (strpos($file_mime_type, 'html') !== false || strpos($file_mime_type, 'text') !== false) {
            $file_url = $value;
            $html = Html::img($file_url, ['class' => 'preview-elfinder preview-' . $this->options['id']]);
        }
        
        echo isset($html) ? $html : null;
        
        //        --------------------------------------------------------------------------
        
        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $inputOptions);
        } else {
            echo Html::textInput($this->name, $this->value, $inputOptions);
        }
        
        echo Html::beginTag('div', ['class' => 'btn-group']);
        echo Html::button(Yii::t('app', 'Browse'), ['id' => $this->options['id'] . 'browse', 'class' => 'btn btn-primary el-finder-btn']);
        echo Html::button(Html::tag('i', null, ['class' => 'fas fa-times']), ['class' => 'btn btn-danger btn-elfinder-remove']);
        echo Html::endTag('div');
        echo Html::endTag('div');

        $settings = array_merge(
            array(
                'places' => "",
                'rememberLastDir' => false,
            ),
            $this->settings
        );

        $settings['dialog'] = array(
            'zIndex' => 400001,
            'width' => 900,
            'modal' => true,
            'title' => "Files",
        );
        
        $settings['editorCallback'] = new JsExpression('function(url) {
            url = decodeURIComponent(url);
            
            $("#" + aFieldId).attr("value", url);
            
            var html, source,
                filetypeImageArr = ["png", "jpg", "jpeg", "ico", "bmp", "svg"],
                filetypeAudioArr = ["mp3", "ogg"],
                filetypeVideoArr = ["mp4", "flv"];
            
            if (filetypeImageArr.includes(url.split(".").pop().toLowerCase())) {
                html = \'<img class="preview-elfinder preview-\' + aFieldId + \'" src="\' + url + \'">\';
            }
            
            if (filetypeAudioArr.includes(url.split(".").pop().toLowerCase())) {
                source = \'<source src="\' + url + \'">\';
                html = \'<audio class="preview-elfinder preview-\' + aFieldId + \'" controls>\' + source + \'</audio>\';
            }
            
            if (filetypeVideoArr.includes(url.split(".").pop().toLowerCase())) {
                source = \'<source src="\' + url + \'">\';
                html = \'<video class="preview-elfinder preview-\' + aFieldId + \'" controls>\' + source + \'</video>\';
            }
            
            $(".preview-" + aFieldId).remove();
            $("#" + aFieldId).closest(".elfinder-container").prepend(html);
            $(document).unbind("keypress keydown keyup");
        }');
        
        $settings['closeOnEditorCallback'] = true;
        $connectorUrl = Json::encode($this->settings['url']);
        $settings = Json::encode($settings);
        $script = <<<EOD
        window.elfinderBrowse = function(field_id, connector) {
            var aFieldId = field_id, aWin = this;
            if($("#elFinderBrowser").length == 0) {
                $("body").append($("<div/>").attr("id", "elFinderBrowser"));
                var settings = $settings;
                settings["url"] = connector;
                $("#elFinderBrowser").elfinder(settings);
            }
            else {
                $("#elFinderBrowser").elfinder("open", connector);
            }
        }
EOD;

        $view = $this->getView();
        ElFinderAsset::register($view);
        $view->registerJs($script, View::POS_READY, $key = 'ServerFileInput#global');

        $js = //'$("#'.$id.'").focus(function(){window.elfinderBrowse("'.$name.'")});'.
            '$("#' . $this->options['id'] . 'browse")'
            . '.click(function(){window.elfinderBrowse("' . $this->options['id'] . '", ' . $connectorUrl . ')});';


        $view->registerJs($js);
    }

}
