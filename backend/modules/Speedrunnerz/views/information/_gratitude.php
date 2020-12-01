<?php

$external_components = [
    'yii2mod/yii2-rbac' => [
        'description' => 'RBAC manager',
        'link' => 'https://github.com/yii2mod/yii2-rbac',
    ],
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
    'vova07/yii2-imperavi-widget' => [
        'description' => 'Imperavi widget',
        'link' => 'https://github.com/vova07/yii2-imperavi-widget',
    ],
    'kartik-v/yii2-widget-select2' => [
        'description' => 'Select2 widget',
        'link' => 'https://github.com/kartik-v/yii2-widget-select2',
    ],
    'kartik-v/yii2-widget-fileinput' => [
        'description' => 'FileInput widget',
        'link' => 'https://github.com/kartik-v/yii2-widget-fileinput',
    ],
    'zxbodya/yii2-elfinder' => [
        'description' => 'ElFinder widget',
        'link' => 'https://github.com/zxbodya/yii2-elfinder',
    ],
];

?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="m-0">
            Фундамент
        </h5>
    </div>
    
    <div class="card-body">
        Выражаем особую благодарность всем разработчикам, которые участвовали при создании
        <a href="https://www.yiiframework.com" target="_blank">Yii2 Framework</a>.<br>
        Если Вам нравится данная CMS, то Вы можете
        <a href="https://www.yiiframework.com/contribute" target="_blank">помочь</a>
        либо
        <a href="https://opencollective.com/yiisoft" target="_blank">поддержать</a>
        команду Yii.
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-primary text-white">
        <h5 class="m-0">
            Сторонние компоненты
        </h5>
    </div>
    
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Ссылка</th>
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