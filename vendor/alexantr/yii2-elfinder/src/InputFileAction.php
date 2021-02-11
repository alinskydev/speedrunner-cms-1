<?php

namespace alexantr\elfinder;

use Yii;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * InputFile action
 */
class InputFileAction extends ClientBaseAction
{
    /**
     * @var string Separator for multiple paths in text input
     */
    public $separator = ',';
    /**
     * @var string Separator for multiple paths in textarea
     */
    public $textareaSeparator = '\n';
    /**
     * @var bool Put file name without path into field
     */
    public $nameOnly = false;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $id = Yii::$app->request->getQueryParam('id');
        $id = Html::encode($id);

        $multiple = Yii::$app->request->getQueryParam('multiple');
        $fileParam = $this->nameOnly ? 'name' : 'url';

        if (!empty($multiple)) {
            $this->settings['commandsOptions']['getfile']['multiple'] = true;
            $callback = <<<JSEXP
function (files) {
    var urls = [], separator = "{$this->separator}", el = window.opener.jQuery("#$id"), value = el.val();
    for (var i in files) {
        urls.push(files[i].$fileParam);
    }
    if (el.prop("tagName").toLowerCase() == "textarea") separator = "{$this->textareaSeparator}";
    if (value) {
        el.val(value + separator + urls.join(separator)).trigger("change");
    } else {
        el.val(urls.join(separator)).trigger("change");
    }
    window.close();
}
JSEXP;
        } else {
            $callback = <<<JSEXP
function (file) {
    var el = window.opener.jQuery("#$id"),
        filetypeImageArr = ["png", "jpg", "jpeg", "ico", "bmp", "svg"],
        filetypeAudioArr = ["mp3", "ogg"],
        filetypeVideoArr = ["mp4", "flv"],
        value = file.$fileParam,
        html;
    
    if (filetypeImageArr.includes(value.split(".").pop().toLowerCase())) {
        html = '<img class="preview-elfinder" src="' + value + '">';
    }
    
    if (filetypeAudioArr.includes(value.split(".").pop().toLowerCase())) {
        html = '<audio class="preview-elfinder" controls><source src="' + value + '"></audio>';
    }
    
    if (filetypeVideoArr.includes(value.split(".").pop().toLowerCase())) {
        html = '<video class="preview-elfinder" controls><source src="' + value + '"></video>';
    }
    
    el.val(value).trigger("change");
    el.closest('.elfinder-container').find('.yii2-elfinder-input-preview').empty().append(html);
    
    window.close();
}
JSEXP;
        }

        $this->settings['getFileCallback'] = new JsExpression($callback);

        return parent::run();
    }
}
