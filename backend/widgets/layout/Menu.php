<?php

namespace backend\widgets\layout;

use Yii;
use yii\helpers\ArrayHelper;


class Menu extends \yii\widgets\Menu
{
    protected function normalizeItems($items, &$active)
    {
        $items = self::addIconToLabelAndActivate($items, Yii::$app->controller->getUniqueId() . '/');
        return parent::normalizeItems($items, $active);
    }
    
    private static function addIconToLabelAndActivate($items, $controller_id)
    {
        $role = Yii::$app->user->identity->role;
        
        foreach ($items as &$item) {
            $item['label'] = ArrayHelper::getValue($item, 'icon') . ArrayHelper::getValue($item, 'label');
            
            if ($url = ArrayHelper::getValue($item, 'url')) {
                $url = is_array($url) ? $url[0] : $url;
                $url = ltrim($url, '/');
                
                if (ArrayHelper::getValue($item, 'active') === null) {
                    $item['active'] = strpos($url, $controller_id) !== false;
                }
                
                if (ArrayHelper::getValue($item, 'visible') === null) {
                    $item['visible'] = $role->service->isAllowedByRoute($url);
                }
            }
            
            if (isset($item['items'])) {
                $item['items'] = self::addIconToLabelAndActivate($item['items'], $controller_id);
            }
        }
        
        return $items;
    }
}
