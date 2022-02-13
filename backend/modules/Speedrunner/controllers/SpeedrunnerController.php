<?php

namespace backend\modules\Speedrunner\controllers;

use Yii;
use yii\web\Controller;


class SpeedrunnerController extends Controller
{
    public function actionIndex()
    {
        $action_types = [
            'module' => [
                'label' => 'Module',
                'actions' => [
                    'module_generator' => [
                        'url' => ['speedrunner/module/generator'],
                        'label' => 'Generator',
                        'bg_class' => 'primary',
                        'icon_class' => 'fas fa-file-code'
                    ],
                    'module_duplicator' => [
                        'url' => ['speedrunner/module/duplicator'],
                        'label' => 'Duplicator',
                        'bg_class' => 'primary',
                        'icon_class' => 'fas fa-copy'
                    ],
                    'module_destroyer' => [
                        'url' => ['speedrunner/module/destroyer'],
                        'label' => 'Destroyer',
                        'bg_class' => 'primary',
                        'icon_class' => 'far fa-times-circle'
                    ],
                ],
            ],
            'staticpage' => [
                'label' => 'Static page',
                'actions' => [
                    'staticpage_generator' => [
                        'url' => ['speedrunner/staticpage/generator'],
                        'label' => 'Generator',
                        'bg_class' => 'warning',
                        'icon_class' => 'fas fa-file-alt'
                    ],
                ],
            ],
        ];
        
        return $this->render('index', [
            'action_types' => $action_types
        ]);
    }
}
