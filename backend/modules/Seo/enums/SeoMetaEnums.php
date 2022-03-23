<?php

namespace backend\modules\Seo\enums;

use Yii;


class SeoMetaEnums
{
    public static function types()
    {
        return [
            'head' => [
                'label' => 'Head',
                'input_type' => 'text_area',
            ],
            'body' => [
                'label' => 'Body',
                'input_type' => 'text_area',
            ],
        ];
    }
}