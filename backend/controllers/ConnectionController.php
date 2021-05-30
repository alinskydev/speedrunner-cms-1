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
                            
                            'disabled' => [
                                'chmod', 'editor', 'netmount', 'parents', 'resize'
                            ],
                            
                            'attributes' => [
	                        	[
	                        		'pattern' => '/\s|\.(html|xhtml|phtml|php|py|pl|sh|xml|js|gitignore|quarantine)$/i', // Dissllow spaces and extensions
	                        		'read' => false,
	                        		'write' => false,
	                        		'locked' => true,
	                        		'hidden' => true,
                                    'message' => 'qwe',
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
//            'tinymce-image-upload' => [
//                'class' => 'alexantr\tinymce\actions\UploadFileAction',
//                'url' => '/uploaded/editor', // Directory URL address, where files are stored.
//                'path' => '@frontend/web/uploaded/editor', // Or absolute path to directory where files are stored.
//            ],
        ];
    }
}
