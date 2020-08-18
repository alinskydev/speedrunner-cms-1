<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseInflector;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

use backend\modules\Seo\models\SeoMeta;

$seo_meta_types = SeoMeta::types();
$meta_tag_exceptions = ['description', 'keywords'];

?>

<?php foreach ($seo_meta_types as $key => $s_m_t) { ?>
    <?php $meta_tag_name = in_array($key, $meta_tag_exceptions) ? 'name' : 'property'; ?>
    <?php $seo_meta_key = isset($seo_meta[$key]) ? $seo_meta[$key] : ['content' => null] ?>
    
    <div class="form-group">
        <label><?= $s_m_t['label'] ?></label>
        <?= Html::input('hidden', "SeoMeta[$key][$meta_tag_name]", $key) ?>
        
        <?php
            switch ($s_m_t['type']) {
                case 'inputField':
                    echo Html::input('text', "SeoMeta[$key][content]", $seo_meta_key['content'], ['class' => 'form-control']);
                    break;
                case 'textArea':
                    echo Html::textArea("SeoMeta[$key][content]", $seo_meta_key['content'], ['class' => 'form-control', 'rows' => 5]);
                    break;
                case 'CKEditor':
                    echo Widget::widget([
                        'name' => "SeoMeta[$key][content]",
                        'value' => $seo_meta_key['content'],
                        'id' => 'seo-meta-' . BaseInflector::slug($s_m_t['label']),
                        'settings' => [
                            'imageUpload' => Yii::$app->urlManager->createUrl('connection/editor-image-upload'),
                            'imageManagerJson' => Yii::$app->urlManager->createUrl('connection/editor-images'),
                        ],
                    ]);
                    break;
                case 'ElFinder':
                    echo ElFinderInput::widget([
                        'connectorRoute' => '/connection/elfinder-file-upload',
                        'name' => "SeoMeta[$key][content]",
                        'value' => $seo_meta_key['content'],
                        'id' => 'seo-meta-' . BaseInflector::slug($s_m_t['label']),
                    ]);
                    break;
            };
        ?>
    </div>
<?php } ?>
