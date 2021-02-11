<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;


class CacheController extends Controller
{
    public function actionRemoveThumbs()
    {
        $dirs = [
            '@frontend/web/assets/elfinder',
            '@frontend/web/assets/thumbs',
        ];
        
        foreach ($dirs as $d) {
            if (is_dir(Yii::getAlias($d))) {
                FileHelper::removeDirectory(Yii::getAlias($d));
                FileHelper::createDirectory(Yii::getAlias($d));
            }
        }
        
        Yii::$app->session->addFlash('success', Yii::t('app', 'Process has been completed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionClear()
    {
        $dirs = [
            '@api/runtime', '@backend/runtime', '@console/runtime', '@frontend/runtime',
            '@api/web/assets', '@backend/web/assets', '@frontend/web/assets',
        ];
        
        foreach ($dirs as $d) {
            if (is_dir(Yii::getAlias($d))) {
                $sub_dirs = FileHelper::findDirectories(Yii::getAlias($d), ['recursive' => false]);
                
                foreach ($sub_dirs as $s) {
                    FileHelper::removeDirectory($s);
                }
            }
        }
        
        Yii::$app->session->addFlash('success', Yii::t('app', 'Process has been completed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
