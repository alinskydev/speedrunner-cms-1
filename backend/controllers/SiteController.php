<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
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
    
    public function actionIndex()
    {
        $this->layout = 'index';
        return $this->render('index');
    }
    
    public function actionError()
    {
        $this->layout = 'error';
        
        return $this->render('error', [
            'exception' => Yii::$app->errorHandler->exception
        ]);
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
}
