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
            Yii::$app->session->addFlash('warning', Yii::t('app', 'Parameter not found'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        switch ($name) {
            case 'bookmarks':
                $bookmarks = Yii::$app->session->get('bookmarks', []);
                $bookmarks[Yii::$app->request->referrer] = $value;
                
                Yii::$app->session->set($name, $bookmarks);
                Yii::$app->session->addFlash('success', Yii::t('app', 'Bookmark has been added'));
                
                return $this->redirect(Yii::$app->request->referrer);
            case 'nav':
                Yii::$app->session->set($name, !Yii::$app->session->get($name));
                return true;
            default:
                Yii::$app->session->addFlash('warning', Yii::t('app', 'Parameter not found'));
                return $this->redirect(Yii::$app->request->referrer);
        }
    }
    
    public function actionRemove()
    {
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');
        
        if (!isset($name) || !isset($value)) {
            Yii::$app->session->addFlash('warning', Yii::t('app', 'Parameter not found'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        switch ($name) {
            case 'bookmarks':
                $bookmarks = Yii::$app->session->get('bookmarks', []);
                ArrayHelper::remove($bookmarks, $value);
                
                Yii::$app->session->set($name, $bookmarks);
                Yii::$app->session->addFlash('success', Yii::t('app', 'Bookmark has been deleted'));
                
                break;
            default:
                Yii::$app->session->addFlash('warning', Yii::t('app', 'Parameter not found'));
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }
}
