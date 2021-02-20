<?php

namespace backend\modules\Banner\enums;

use Yii;


class BannerEnums
{
    public static function locations()
    {
        return [
            'slider_home' => [
                'label' => Yii::t('app', 'Slider home'),
            ],
            'slider_about' => [
                'label' => Yii::t('app', 'Slider about'),
            ],
        ];
    }
}
