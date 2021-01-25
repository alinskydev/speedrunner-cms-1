<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

use frontend\forms\ProfileForm;


class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionUpdate()
    {
        $model = new ProfileForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->update()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Profile has been updated.'));
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
