<?php

namespace frontend\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;


class ProductCategoriesUrlRule extends BaseObject implements UrlRuleInterface
{
    public $route;
    
    public function createUrl($manager, $route, $params)
    {
        if ($route == $this->route) {
            $path = '/catalog/' . $params['full_url'];
            unset($params['full_url']);
            
            if ($params) {
                $path .= '?';
                foreach ($params as $key => $p) {
                    $path .= $key . '=' . $p . '&';
                }
            }
            
            return rtrim($path, '&');
        } else {
            return false;
        }
    }
    
    public function parseRequest($manager, $request)
    {
        $path = explode('/', $request->pathInfo);
        
        if (array_shift($path) == 'catalog') {
            return [$this->route, ['full_url' => implode('/', $path)]];
        } else {
            return false;
        }
    }
}
