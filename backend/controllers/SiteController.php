<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class SiteController extends Controller
{
    public function actionError()
    {
        $this->layout = 'error';
        
        return $this->render('error', [
            'exception' => Yii::$app->errorHandler->exception
        ]);
    }
    
    public function actionIndex()
    {
        $this->layout = 'index';
        return $this->render('index');
    }
    
    public function actionChangePassword()
    {
        $model = Yii::$app->user->identity;
        
        if ($new_password = ArrayHelper::getValue(Yii::$app->request->post(), 'User.new_password')) {
            $model->new_password = $new_password;
            
            if ($model->save()) {
                Yii::$app->session->removeFlash('success');
                Yii::$app->session->addFlash('success', Yii::t('app', 'Password has been changed'));
                
                return $this->refresh();
            }
        }
        
        return $this->render('change_password', [
            'model' => $model,
        ]);
    }
    
    public function actionInformation()
    {
        return 'CMS version date: 2021-02-14';
    }
}
