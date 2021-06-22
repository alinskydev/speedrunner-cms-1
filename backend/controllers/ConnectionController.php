<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use zxbodya\yii2\elfinder\ConnectorAction;


class ConnectionController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == 'tinymce-image-upload') {
            $this->enableCsrfValidation = false;
        }
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        $upload_allow = [];
        
        array_walk(Yii::$app->params['extensions'], function($extensions, $key) use (&$upload_allow) {
            array_walk($extensions, function($value) use (&$upload_allow, $key) {
                $upload_allow[] = "$key/$value";
            });
        });
        
        return [
            'elfinder' => [
                'class' => 'alexantr\elfinder\ConnectorAction',
                'options' => [
                    'roots' => [
                        [
                            'driver' => 'LocalFileSystem',
                            'path' => Yii::getAlias('@frontend/web/uploads/'),
                            'URL' => '/uploads/',
                            'mimeDetect' => 'internal',
                            'imgLib' => 'auto',
                            'tmbPath' => Yii::getAlias('@frontend/web/assets/elfinder'),
                            'tmbURL' => '/assets/elfinder',
                            'tmbCrop' => false,
                            
                            'disabled' => ['chmod', 'editor', 'netmount', 'parents', 'resize', 'extract', 'mkfile'],
                            'uploadDeny' => ['all'],
                            'uploadAllow' => $upload_allow,
                            'uploadOrder' => ['deny', 'allow'],
                            
                            'attributes' => [
	                        	[
	                        		'pattern' => '/\.(html|xhtml|phtml|php|py|pl|sh|xml|js|gitignore|quarantine)$/',
	                        		'read' => false,
	                        		'write' => false,
	                        		'locked' => true,
	                        		'hidden' => true,
	                        	]
	                        ],
                        ],
                    ],
                ],
            ],
            'elfinder-input' => [
                'class' => 'alexantr\elfinder\InputFileAction',
                'connectorRoute' => 'elfinder',
            ],
            
            'tinymce' => [
                'class' => 'alexantr\elfinder\TinyMCEAction',
                'connectorRoute' => 'elfinder',
            ],
            'tinymce-image-upload' => [
                'class' => 'alexantr\tinymce\actions\UploadFileAction',
                'url' => '/uploaded/editor',
                'path' => '@frontend/web/uploaded/editor',
            ],
        ];
    }
}
