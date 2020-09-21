<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;


class CacheController extends Controller
{
    public function actionRefreshRoutes()
    {
        Yii::$app->sr->translation->fixMessages();
        Yii::$app->session->addFlash('success', Yii::t('app', 'Process has been completed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionRemoveThumbs()
    {
        $dir = Yii::getAlias('@frontend/web/assets/thumbs');
        FileHelper::removeDirectory($dir);
        FileHelper::createDirectory($dir);
        Yii::$app->session->addFlash('success', Yii::t('app', 'Process has been completed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionClear()
    {
        $dirs = [
            '@api/runtime', '@backend/runtime', '@frontend/runtime',
            '@backend/web/assets', '@frontend/web/assets',
        ];
        
        foreach ($dirs as $d) {
            if (is_dir(Yii::getAlias($d))) {
                $sub_dirs = FileHelper::findDirectories(Yii::getAlias($d));
                
                foreach ($sub_dirs as $s) {
                    FileHelper::removeDirectory($s);
                }
            }
        }
        
        Yii::$app->session->addFlash('success', Yii::t('app', 'Process has been completed'));
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
