<?php

namespace yii2mod\rbac\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;


class RbacController extends Controller
{
    public function actionIndex()
    {
        $actions = [
            'routes' => [
                'url' => ['rbac/route'],
                'label' => 'Routes',
                'bg_class' => 'primary',
                'icon_class' => 'fas fa-link'
            ],
            'rules' => [
                'url' => ['rbac/rule'],
                'label' => 'Rules',
                'bg_class' => 'success',
                'icon_class' => 'fas fa-list-ul'
            ],
            'roles' => [
                'url' => ['rbac/role'],
                'label' => 'Roles',
                'bg_class' => 'warning',
                'icon_class' => 'fas fa-tags'
            ],
            'assignments' => [
                'url' => ['rbac/assignment'],
                'label' => 'Assignments',
                'bg_class' => 'info',
                'icon_class' => 'fas fa-user-tag'
            ],
            'permissions' => [
                'url' => ['rbac/permission'],
                'label' => 'Permissions',
                'bg_class' => 'primary',
                'icon_class' => 'fas fa-unlock-alt'
            ],
        ];
        
        return $this->render('index', [
            'actions' => $actions
        ]);
    }
}
