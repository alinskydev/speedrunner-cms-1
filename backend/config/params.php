<?php

return [
    'checkbox_template' => '<div class="custom-control custom-checkbox">{input}{beginLabel}{labelTitle}{endLabel}{hint}{error}</div>',
    'switcher_template' => '<div class="custom-control custom-switch">{input}{beginLabel}{labelTitle}{endLabel}{hint}{error}</div>',
    
    'fileInput_pluginOptions' => [
        'initialPreviewAsData' => true,
        'overwriteInitial' => false,
        'maxFileSize' => 1024,
        'showCaption' => false,
        'showUpload' => false,
        'showRemove' => true,
        'showDelete' => false,
        'showCancel' => false,
        'showClose' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fas fa-folder-open"></i>',
        'removeClass' => 'btn btn-danger btn-block float-right mt-1 mb-2',
        'removeIcon' => '<i class="fas fa-trash-alt"></i>',
        'fileActionSettings' => [
            'dragClass' => 'text-primary',
            'dragIcon' => '<i class="fas fa-arrows-alt"></i>',
            'zoomClass' => 'btn btn-info',
            'zoomIcon' => '<i class="fas fa-search-plus"></i>',
            'downloadClass' => 'btn btn-primary pull-left',
            'downloadIcon' => '<i class="fas fa-cloud-download-alt"></i>',
            'removeClass' => 'btn btn-danger',
            'removeIcon' => '<i class="fas fa-trash-alt"></i>',
        ],
        'layoutTemplates' => [
            'actions' => '{drag}<div class="file-actions"><div class="file-footer-buttons">{zoom} {download} {delete}</div></div>',
        ],
        'previewZoomButtonIcons' => [
            'prev' => '<i class="fas fa-caret-left"></i>',
            'next' => '<i class="fas fa-caret-right"></i>',
            'toggleheader' => '<i class="far fa-window-maximize"></i>',
            'fullscreen' => '<i class="fas fa-compress"></i>',
            'borderless' => '<i class="fas fa-arrows-alt"></i>',
            'close' => '<i class="fas fa-times"></i>',
        ]
    ],
    
    'pager_options' => [
        'options' => ['class' => 'pagination'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
        'firstPageLabel' => '<i class="fas fa-angle-double-left"></i>',
        'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
        'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
        'lastPageLabel' => '<i class="fas fa-angle-double-right"></i>',
    ]
];
