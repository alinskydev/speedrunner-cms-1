<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
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
        foreach (Yii::$app->params['extensions'] as $key => $extensions) {
            foreach ($extensions as $value) {
                $upload_allow[] = "$key/$value";
            }
        }
        
        return [
            'elfinder' => [
                'class' => 'alexantr\elfinder\ConnectorAction',
                'options' => [
                    'bind' => [
                        'mkdir.pre mkfile.pre rename.pre duplicate.pre paste.pre' => function($cmd, &$result, $args, $elfinder) {
                            $result['name'] = str_replace(' ', '-', Inflector::transliterate($result['name']));
                        },
                        'upload.presave' => function($cmd, &$result, $args, $elfinder) {
                            $result = str_replace(' ', '-', Inflector::transliterate($result));
                        },
                    ],
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
                            'uploadAllow' => $upload_allow ?? [],
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
