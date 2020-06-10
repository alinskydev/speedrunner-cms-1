<?php

namespace backend\modules\SpeedRunner\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;


class SpeedrunnerController extends Controller
{
    public function actionIndex()
    {
        $actions = [
            'module_generator' => [
                'url' => ['speedrunner/module/generator'],
                'label' => 'Module Generator',
                'bg_class' => 'primary',
                'icon_class' => 'fas fa-file-code'
            ],
            'module_duplicator' => [
                'url' => ['speedrunner/module/duplicator'],
                'label' => 'Module Duplicator',
                'bg_class' => 'success',
                'icon_class' => 'fas fa-copy'
            ],
            'page_generator' => [
                'url' => ['speedrunner/page/generator'],
                'label' => 'Page Generator',
                'bg_class' => 'warning',
                'icon_class' => 'fas fa-file-alt'
            ],
            'block_generator' => [
                'url' => ['speedrunner/block/generator'],
                'label' => 'Block Generator',
                'bg_class' => 'info',
                'icon_class' => 'fas fa-th'
            ],
            'api_generator' => [
                'url' => ['speedrunner/api/generator'],
                'label' => 'API Generator',
                'bg_class' => 'primary',
                'icon_class' => 'fas fa-mobile-alt'
            ],
        ];
        
        return $this->render('index', [
            'actions' => $actions
        ]);
    }
}
