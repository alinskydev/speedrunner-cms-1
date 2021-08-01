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
        $condition_1 = $this->model->id == 1;
        $condition_2 = !in_array($route, Yii::$app->helpers->array->leaves($this->model->enums->routes()));
        $condition_3 = in_array($route, $this->model->routes);
        
        return $condition_1 || $condition_2 || $condition_3;
    }
}