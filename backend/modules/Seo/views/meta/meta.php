<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use alexantr\elfinder\InputFile;
use vova07\imperavi\Widget;

use backend\modules\Seo\models\SeoMeta;
use backend\modules\Seo\services\SeoMetaService;

$seo_meta = (new SeoMetaService($model))->getMetaValue();
$seo_meta_types = (new SeoMeta())->enums->types();

?>

<?php foreach ($seo_meta_types as $key => $s_m_t) { ?>
    <div class="form-group">
        <label><?= $s_m_t['label'] ?></label>
        
        <?php
            $value = ArrayHelper::getValue($seo_meta, $key);
            
            switch ($s_m_t['input_type']) {
                case 'text_input':
                    echo Html::input('text', "SeoMeta[$key]", $value, ['class' => 'form-control']);
                    break;
                case 'text_area':
                    echo Html::textArea("SeoMeta[$key]", $value, ['class' => 'form-control', 'rows' => 10]);
                    break;
                case 'imperavi':
                    echo Widget::widget([
                        'name' => "SeoMeta[$key]",
                        'value' => $value,
                        'id' => 'seo-meta-' . Inflector::slug($key),
                    ]);
                    break;
                case 'elfinder':
                    echo InputFile::widget([
                        'name' => "SeoMeta[$key]",
                        'value' => $value,
                        'id' => 'seo-meta-' . Inflector::slug($key),
                    ]);
                    break;
            };
        ?>
    </div>
<?php } ?>
