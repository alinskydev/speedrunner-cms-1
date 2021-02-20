<?php

namespace backend\modules\Blog\enums;

use Yii;


class BlogCommentEnums
{
    public static function statuses()
    {
        return [
            'new' => [
                'label' => Yii::t('app', 'New'),
            ],
            'published' => [
                'label' => Yii::t('app', 'Published'),
            ],
        ];
    }
}
