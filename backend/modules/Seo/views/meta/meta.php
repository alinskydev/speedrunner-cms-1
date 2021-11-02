<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use alexantr\elfinder\InputFile;
use alexantr\tinymce\TinyMCE;

use backend\modules\Seo\models\SeoMeta;
use backend\modules\Seo\services\SeoMetaService;

$seo_meta = (new SeoMetaService($model))->getMetaValue(true);
$seo_meta_types = (new SeoMeta())->enums->types();

?>

<ul class="nav nav-tabs nav-input-tabs">
    <?php foreach (Yii::$app->urlManager->languages as $lang_code => $lang) { ?>
        <li class="nav-item">
            <?= Html::a(
                Html::img(Yii::$app->helpers->image->thumb($lang['image'], [30, 20], 'crop')),
                "#seo-meta-$lang_code-tab",
                [
                    'class' => 'nav-link ' . ($lang_code == Yii::$app->language ? 'active' : null),
                    'data-toggle' => 'tab',
                ]
            ) ?>
        </li>
    <?php } ?>
</ul>

<div class="tab-content p-3 border border-top-0">
    <?php foreach (Yii::$app->urlManager->languages as $lang_code => $lang) { ?>
        <div id="seo-meta-<?= $lang_code ?>-tab" class="tab-pane <?= $lang_code == Yii::$app->language ? 'active' : 'fade' ?>">
            <?php foreach ($seo_meta_types as $key => $s_m_t) { ?>
                <div class="form-group">
                    <?php
                        echo Html::label($s_m_t['label']);
                        $value = ArrayHelper::getValue($seo_meta, "$lang_code.$key");
                        
                        switch ($s_m_t['input_type']) {
                            case 'text_input':
                                echo Html::input('text', "SeoMeta[$lang_code][$key]", $value, [
                                    'id' => "seo-meta-$lang_code-$key",
                                    'class' => 'form-control',
                                ]);
                                break;
                            case 'text_area':
                                echo Html::textArea("SeoMeta[$lang_code][$key]", $value, [
                                    'id' => "seo-meta-$lang_code-$key",
                                    'class' => 'form-control',
                                    'rows' => 10,
                                ]);
                                break;
                            case 'file_manager':
                                echo InputFile::widget([
                                    'name' => "SeoMeta[$lang_code][$key]",
                                    'value' => $value,
                                    'id' => "seo-meta-$lang_code-$key",
                                ]);
                                break;
                            case 'text_editor':
                                echo TinyMCE::widget([
                                    'name' => "SeoMeta[$lang_code][$key]",
                                    'value' => $value,
                                    'id' => "seo-meta-$lang_code-$key",
                                ]);
                                break;
                        };
                    ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
