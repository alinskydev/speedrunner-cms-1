<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\forms\LoginForm;

use backend\modules\User\models\User;


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
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
    
    public function actionLogin()
    {
        $this->layout = 'login';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = null;
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
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
}
