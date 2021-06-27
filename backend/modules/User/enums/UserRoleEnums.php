<?php

namespace backend\modules\User\enums;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;


class UserRoleEnums
{
    public static function routes()
    {
        return Yii::$app->cache->getOrSet('user_roles', fn() => self::availableRoutes(), 0);
    }
    
    private static function availableRoutes()
    {
        $modules_dir = Yii::getAlias('@backend/modules');
        $controllers_dir = Yii::getAlias('@backend/controllers');
        
        $controllers_files = FileHelper::findFiles($modules_dir, [
            'only' => ['*/controllers/*.php'],
            'except' => ['/Speedrunner/', 'User/controllers/NotificationController.php'],
        ]);
        
        $controllers_files[] = "$controllers_dir/CacheController.php";
        
        foreach ($controllers_files as $file) {
            $file = str_replace([$modules_dir, $controllers_dir, 'Controller.php'], null, $file);
            $file = str_replace('\\', '/', $file);
            $file = str_replace('/controllers', null, $file);
            $file = ltrim($file, '/');
            
            $route_arr = explode('/', $file);
            $module_id = Inflector::camel2id($route_arr[0], '-');
            $controller_id = Inflector::camel2id($route_arr[1] ?? null, '-');
            $route = $controller_id ? "$module_id/$controller_id" : $module_id;
            
            $controller = Yii::$app->createController($route)[0];
            $actions = array_keys($controller->actions());
            $inline_actions = [];
            
            foreach (get_class_methods($controller) as $method) {
                if (strpos($method, 'action') !== false && $method != 'actions') {
                    $inline_actions[] = Inflector::camel2id(ltrim($method, 'action'), '-');
                }
            }
            
            if ($controller_id) {
                $routes[$module_id][$controller_id] = array_merge($actions, $inline_actions);
            } else {
                $routes[$module_id] = array_merge($actions, $inline_actions);
            }
        }
        
        return $routes;
    }
}