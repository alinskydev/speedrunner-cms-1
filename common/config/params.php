<?php

return [
    'is_development_ip' => in_array($_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? null, [
        '127.0.0.1',
    ]),
    
    'input_types' => [
        'text_input' => 'Text field',
        'text_area' => 'Text area',
        'checkbox' => 'Checkbox',
        'select' => 'Select',
        'select2_ajax' => 'Select 2 (AJAX)',
        'file_manager' => 'File manager',
        'text_editor' => 'Text editor',
        'files' => 'Files',
        'groups' => 'Groups',
    ],
    
    'extensions' => [
        'application' => ['doc', 'docx', 'rtf', 'xls', 'xlsx', 'pdf'], 
        'audio' => ['mp3', 'ogg'],
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg+xml'],
        'text' => ['txt', 'csv'],
        'video' => ['mp4', 'flv'],
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
