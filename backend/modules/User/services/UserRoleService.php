<?php

namespace backend\modules\User\services;

use Yii;
use yii\helpers\ArrayHelper;
use speedrunner\services\ActiveService;


class UserRoleService extends ActiveService
{
    public function createTreeFromRoutes($routes, $selection, $parent_key = null)
    {
        foreach ($routes as $key => $route) {
            if (is_array($route)) {
                $total_key = $parent_key ? "$parent_key/$key" : $key;
                
                $result[$key]['key'] = $total_key;
                $result[$key]['title'] = ucfirst($key);
                $result[$key]['children'] = $this->createTreeFromRoutes($route, $selection, $total_key);
            } else {
                $total_key = "$parent_key/$route";
                
                $result[$route]['key'] = $total_key;
                $result[$route]['title'] = $route;
                $result[$route]['selected'] = in_array($total_key, $selection);
                $result[$route]['children'] = [];
            }
        }
        
        return array_values($result);
    }
    
    public function isAllowedByRoute($route)
    {
        return $this->model->id == 1 || !in_array($route, Yii::$app->services->array->leaves($this->model->enums->routes())) || in_array($route, $this->model->routes);
    }
}