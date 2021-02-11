<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\actions as Actions;
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
    
    public function actions()
    {
        return [
            'update' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => ProfileForm::className(),
                'render_view' => 'update',
                'run_method' => 'update',
                'success_message' => 'Profile has been updated',
                'redirect_route' => ['update'],
            ],
        ];
    }
}
