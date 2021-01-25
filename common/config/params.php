<?php

return [
    'input_types' => [
        'textInput' => 'Text field',
        'textArea' => 'Text area',
        'checkbox' => 'Checkbox',
        'CKEditor' => 'Text editor',
        'ElFinder' => 'File manager',
        'images' => 'Images',
        'groups' => 'Groups',
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
                'created', 'updated', 'datetime', 'published'
            ]
        ],
        'date' => [
            'formats' => [
                'afterFind' => 'd.m.Y',
                'beforeSave' => 'Y-m-d',
                'beforeSearch' => 'Y-m-d',
                'afterSearch' => 'd.m.Y',
            ],
            'attributes' => [
                'date'
            ]
        ],
        'time' => [
            'formats' => [
                'afterFind' => 'H:i',
                'beforeSave' => 'H:i:s',
                'beforeSearch' => 'H:i',
                'afterSearch' => 'H:i',
            ],
            'attributes' => [
                'time'
            ]
        ],
        'month' => [
            'formats' => [
                'afterFind' => 'm.Y',
                'beforeSave' => 'Y-m',
                'beforeSearch' => 'Y-m',
                'afterSearch' => 'm.Y',
            ],
            'attributes' => [
                'month'
            ]
        ],
    ],
];
