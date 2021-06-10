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
            case 'nav':
                Yii::$app->session->set($name, !Yii::$app->session->get($name));
                return true;
            default:
                Yii::$app->session->addFlash('warning', Yii::t('app', 'Parameter not found'));
                return $this->redirect(Yii::$app->request->referrer);
        }
    }
}
