<?php

namespace backend\modules\Seo\enums;

use Yii;


class SeoMetaEnums
{
    public static function types()
    {
        return [
            'title' => [
                'label' => 'Title',
                'input_type' => 'text_input',
                'register_type' => 'title',
            ],
            'description' => [
                'label' => 'Description',
                'input_type' => 'text_area',
                'register_type' => 'name',
            ],
            'og:title' => [
                'label' => 'Og:title',
                'input_type' => 'text_input',
                'register_type' => 'property',
            ],
            'og:description' => [
                'label' => 'Og:description',
                'input_type' => 'text_area',
                'register_type' => 'property',
            ],
            'og:image' => [
                'label' => 'Og:image',
                'input_type' => 'elfinder',
                'register_type' => 'url',
            ]
        ];
    }
}