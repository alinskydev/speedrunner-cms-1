<?php

namespace backend\modules\Staticpage\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\caching\TagDependency;

use backend\modules\Staticpage\models\Staticpage;


class StaticpageService
{
    private static $pages = null;
    
    public function __construct()
    {
        if (self::$pages === null) {
            self::$pages = Yii::$app->db->cache(function($db) {
                return Staticpage::find()->with(['blocks'])->indexBy('name')->all();
            }, 0, new TagDependency(['tags' => 'staticpages']));
        }
    }
    
    public function __get($name)
    {
        if ($page = ArrayHelper::getValue(self::$pages, $name)) {
            return [
                'page' => $page,
                'blocks' => Yii::$app->helpers->array->asObjects(ArrayHelper::map($page->blocks, 'name', 'value')),
            ];
        } else {
            throw new \yii\web\HttpException(404, "The requested static page '$name' not found");
        }
    }
}
