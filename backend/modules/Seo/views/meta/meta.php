<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseInflector;
use vova07\imperavi\Widget;
use zxbodya\yii2\elfinder\ElFinderInput;

use backend\modules\Seo\models\SeoMeta;
use backend\modules\Seo\services\SeoMetaService;

$seo_meta = (new SeoMetaService($model))->getMetaValue();
$seo_meta_types = SeoMeta::types();

?>

<?php foreach ($seo_meta_types as $key => $s_m_t) { ?>
    <div class="form-group">
        <label><?= $s_m_t['label'] ?></label>
        
        <?php
            $value = ArrayHelper::getValue($seo_meta, $key);
            
            switch ($s_m_t['type']) {
                case 'inputField':
                    echo Html::input('text', "SeoMeta[$key]", $value, ['class' => 'form-control']);
                    break;
                case 'textArea':
                    echo Html::textArea("SeoMeta[$key]", $value, ['class' => 'form-control', 'rows' => 5]);
                    break;
                case 'CKEditor':
                    echo Widget::widget([
                        'name' => "SeoMeta[$key]",
                        'value' => $value,
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
                        'name' => "SeoMeta[$key]",
                        'value' => $value,
                        'id' => 'seo-meta-' . BaseInflector::slug($s_m_t['label']),
                    ]);
                    break;
            };
        ?>
    </div>
<?php } ?>
