<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use zxbodya\yii2\elfinder\ConnectorAction;


class ConnectionController extends Controller
{
    public function actions()
    {
        return [
            'editor-image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => '/uploaded/editor', // Directory URL address, where files are stored.
                'path' => '@frontend/web/uploaded/editor', // Or absolute path to directory where files are stored.
            ],
            'editor-images' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => '/uploaded/editor', // Directory URL address, where files are stored.
                'path' => '@frontend/web/uploaded/editor', // Or absolute path to directory where files are stored.
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']], // These options are by default.
            ],
            'elfinder-file-upload' => [
                'class' => ConnectorAction::className(),
                'settings' => [
                    'root' => Yii::getAlias('@frontend/web/uploads/'),
                    'URL' => '/uploads/',
                    'rootAlias' => 'Home',
                    'uploadDeny' => [
                        'text/x-',
                        'text/javascript',
                        'application/x-',
                    ],
                    'disabled' => ['read', 'edit', 'rename', 'extract'],
                    'tmbDir' => '../assets/elfinder',
                ],
            ],
        ];
    }
}
