<?php

namespace api\modules\v1\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use frontend\forms\ProfileForm;
use backend\modules\User\models\User;


class ProfileController extends RestController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'information' => ['get'],
                    'update' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'update' => [
                'class' => Actions\rest\FormAction::className(),
                'model_class' => ProfileForm::className(),
                'model_files' => ['image'],
                'run_method' => 'update',
            ],
        ];
    }
    
    public function actionInformation()
    {
        return Yii::$app->user->identity;
    }
}
