<?php

return [
    'input_types' => [
        'text_input' => 'Text field',
        'text_area' => 'Text area',
        'checkbox' => 'Checkbox',
        'select' => 'Select',
        'select2_ajax' => 'Select 2 (AJAX)',
        'elfinder' => 'File manager',
        'imperavi' => 'Text editor',
        'files' => 'Files',
        'groups' => 'Groups',
    ],
    
    'formats' => [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    ],
    
    'date_formats' => [
        'datetime' => [
            'formats' => [
                'afterFind' => 'd.m.Y H:i',
                'beforeSave' => 'Y-m-d H:i:s',
                'beforeSearch' => 'Y-m-d',
                'afterSearch' => 'd.m.Y',
            ],
            'attributes' => [
                'created_at', 'updated_at', 'published_at', 'datetime',
            ],
        ],
        'date' => [
            'formats' => [
                'afterFind' => 'd.m.Y',
                'beforeSave' => 'Y-m-d',
                'beforeSearch' => 'Y-m-d',
                'afterSearch' => 'd.m.Y',
            ],
            'attributes' => [
                'date',
            ],
        ],
        'time' => [
            'formats' => [
                'afterFind' => 'H:i',
                'beforeSave' => 'H:i:s',
                'beforeSearch' => 'H:i',
                'afterSearch' => 'H:i',
            ],
            'attributes' => [
                'time',
            ],
        ],
        'month' => [
            'formats' => [
                'afterFind' => 'm.Y',
                'beforeSave' => 'Y-m',
                'beforeSearch' => 'Y-m',
                'afterSearch' => 'm.Y',
            ],
            'attributes' => [
                'month',
            ],
        ],
    ],
];
