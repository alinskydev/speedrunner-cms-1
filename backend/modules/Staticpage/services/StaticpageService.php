<?php

namespace backend\modules\Staticpage\services;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Staticpage\models\Staticpage;


class StaticpageService
{
    private static $pages = null;
    
    public function __construct()
    {
        if (static::$pages === null) {
            static::$pages = Staticpage::find()->with(['blocks'])->indexBy('name')->all();
        }
    }
    
    public function __get($name)
    {
        if ($page = ArrayHelper::getValue(static::$pages, $name)) {
            return [
                'page' => $page,
                'blocks' => ArrayHelper::map($page->blocks, 'name', 'value'),
            ];
        } else {
            throw new \yii\web\HttpException(404, 'The requested static page not found');
        }
    }
}
