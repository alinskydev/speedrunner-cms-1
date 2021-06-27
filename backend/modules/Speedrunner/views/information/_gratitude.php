<?php

$external_components = [
    'yurkinx/yii2-image' => [
        'description' => 'Image helper component',
        'link' => 'https://github.com/yurkinx/yii2-image',
    ],
    'creocoder/yii2-nested-sets' => [
        'description' => 'Nested sets component',
        'link' => 'https://github.com/creocoder/yii2-nested-sets',
    ],
    'wokster/yii2-nested-sets-tree-behavior' => [
        'description' => 'Nested sets tree behavior',
        'link' => 'https://github.com/wokster/yii2-nested-sets-tree-behavior',
    ],
    'wbraganca/yii2-fancytree-widget' => [
        'description' => 'Fancytree widget',
        'link' => 'https://github.com/wbraganca/yii2-fancytree-widget',
    ],
    'kartik-v/yii2-widget-select2' => [
        'description' => 'Select2 widget',
        'link' => 'https://github.com/kartik-v/yii2-widget-select2',
    ],
    'kartik-v/yii2-widget-fileinput' => [
        'description' => 'FileInput widget',
        'link' => 'https://github.com/kartik-v/yii2-widget-fileinput',
    ],
    'alexantr/yii2-tinymce' => [
        'description' => 'TinyMCE widget',
        'link' => 'https://github.com/alexantr/yii2-tinymce',
    ],
    'alexantr/yii2-elfinder' => [
        'description' => 'ElFinder widget',
        'link' => 'https://github.com/alexantr/yii2-elfinder',
    ],
];

?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="m-0">
            Foundation
        </h5>
    </div>
    
    <div class="card-body">
        Special thanks to the <a href="https://www.yiiframework.com" target="_blank">Yii2 Framework</a> development group.<br>
        If you like this CMS, then you can <a href="https://www.yiiframework.com/contribute" target="_blank">help</a> or
        <a href="https://opencollective.com/yiisoft" target="_blank">donate</a> to Yii Framework team.
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-primary text-white">
        <h5 class="m-0">
            Third-party components
        </h5>
    </div>
    
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Link</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($external_components as $key => $c) { ?>
                    <tr>
                        <td>
                            <code><?= $key ?></code>
                        </td>
                        <td>
                            <a href="<?= $c['link'] ?>" target="_blank">
                                <?= $c['description'] ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>