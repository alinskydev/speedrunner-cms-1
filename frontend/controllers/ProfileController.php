<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use frontend\forms\ProfileForm;


class ProfileController extends Controller
{
    protected $user;
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $this->user = Yii::$app->user->identity;
        return parent::beforeAction($action);
    }
    
    public function actionUpdate()
    {
        $model = new ProfileForm(['user' => $this->user]);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->update()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Profile saved'));
            } else {
                Yii::$app->session->setFlash('danger', Yii::t('app', 'An error occured'));
            }
            
            return $this->refresh();
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
