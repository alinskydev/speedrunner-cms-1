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
            'body_top' => [
                'label' => 'Body top',
                'input_type' => 'text_area',
            ],
            'body_bottom' => [
                'label' => 'Body bottom',
                'input_type' => 'text_area',
            ],
        ];
    }
}