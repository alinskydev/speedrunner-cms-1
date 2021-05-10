<?php

Yii::$container->set('yii\bootstrap\ActiveField', [
    'checkboxTemplate' => '<div class="custom-control custom-switch">{input}{beginLabel}{labelTitle}{endLabel}{hint}{error}</div>',
]);

Yii::$container->set('yii\data\ActiveDataProvider', [
    'pagination' => [
        'defaultPageSize' => 30,
        'pageSizeLimit' => [1, 30],
    ],
]);

Yii::$container->set('yii\widgets\LinkPager', [
    'options' => ['class' => 'pagination'],
    'linkContainerOptions' => ['class' => 'page-item'],
    'linkOptions' => ['class' => 'page-link'],
    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
    'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
    'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
    'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
    'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
]);

Yii::$container->set('yii\bootstrap\Modal', [
    'headerOptions' => ['class' => 'modal-header flex-row-reverse'],
    'closeButton' => [
        'class' => 'close float-right',
    ],
]);

Yii::$container->set('alexantr\tinymce\TinyMCE', [
    'clientOptions' => [
        'height' => '300px',
        'relative_urls' => false,
        'force_p_newlines' => true,
        'forced_root_block' => false,
        'fontsize_formats' => '8px 10px 12px 14px 16px 18px 24px 36px 48px',
        'plugins' => [
            'advlist autolink lists link charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'table contextmenu paste textcolor colorpicker advcode',
            'media image',
        ],
        'menu' => [],
        'toolbar' => [
            implode(' | ', [
                'undo redo', 'cut copy paste',
                'fontselect', 'fontsizeselect', 'styleselect',
                'bold italic underline strikethrough superscript subscript',
                'forecolor backcolor',
            ]),
            implode(' | ', [
                'outdent indent',
                'alignleft aligncenter alignright alignjustify',
                'bullist numlist table',
                'link anchor image media', 'charmap',
                'searchreplace visualblocks preview code fullscreen',
            ]),
        ],
    ],
]);
