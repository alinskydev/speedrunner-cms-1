<?php

namespace backend\widgets\layout;

use Yii;
use yii\helpers\ArrayHelper;


class Menu extends \yii\widgets\Menu
{
    protected function normalizeItems($items, &$active)
    {
        $items = self::addIconToLabelAndActivate($items, Yii::$app->controller->getUniqueId());
        return parent::normalizeItems($items, $active);
    }
    
    private static function addIconToLabelAndActivate($items, $controller_id)
    {
        foreach ($items as &$item) {
            $item['label'] = ArrayHelper::getValue($item, 'icon') . ArrayHelper::getValue($item, 'label');
            
            if (ArrayHelper::getValue($item, 'active') === null && $url = ArrayHelper::getValue($item, 'url')) {
                if (is_array($url)) {
                    $item['active'] = strpos($url[0], $controller_id) !== false;
                } else {
                    $item['active'] = strpos($url, $controller_id) !== false;
                }
            }
            
            if (isset($item['items'])) {
                $item['items'] = self::addIconToLabelAndActivate($item['items'], $controller_id);
            }
        }
        
        return $items;
    }
}
