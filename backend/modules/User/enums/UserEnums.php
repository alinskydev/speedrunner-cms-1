<?php

namespace backend\modules\User\enums;

use Yii;
use yii\helpers\ArrayHelper;


class UserEnums
{
    public static function designThemes()
    {
        return [
            'nav_left' => [
                'label' => Yii::t('app', 'Left menu'),
            ],
            'nav_full' => [
                'label' => Yii::t('app', 'Full menu'),
            ],
        ];
    }
    
    public static function designFonts()
    {
        return [
            'roboto' => [
                'label' => 'Roboto',
            ],
            'oswald' => [
                'label' => 'Oswald',
            ],
            'ibm_plex_sans' => [
                'label' => 'IBM Plex Sans',
            ],
            'montserrat' => [
                'label' => 'Montserrat',
            ],
        ];
    }
}