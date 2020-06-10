<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;


class SessionController extends Controller
{
    public function actionSet()
    {
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');
        
        if (!isset($name) || !isset($value)) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Parameter not found'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        switch ($name) {
            case 'theme_dark':
                Yii::$app->session->set($name, (bool)$value);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Theme has been changed'));
                
                break;
            case 'bookmarks':
                $bookmarks = Yii::$app->session->get('bookmarks', []);
                $bookmarks[Yii::$app->request->referrer] = $value;
                
                Yii::$app->session->set($name, $bookmarks);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Bookmark has been added'));
                
                break;
            default:
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Parameter not found'));
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionRemove()
    {
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');
        
        if (!isset($name) || !isset($value)) {
            Yii::$app->session->setFlash('warning', Yii::t('app', 'Parameter not found'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        switch ($name) {
            case 'bookmarks':
                $bookmarks = Yii::$app->session->get('bookmarks', []);
                ArrayHelper::remove($bookmarks, $value);
                
                Yii::$app->session->set($name, $bookmarks);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Bookmark has been deleted'));
                
                break;
            default:
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Parameter not found'));
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
