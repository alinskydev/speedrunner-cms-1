<?php

namespace api\controllers;

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
            'auth' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'view' => ['get'],
                    'update' => ['post'],
                    'file-delete' => ['post'],
                ],
            ],
        ]);
    }
    
    public function actions()
    {
        return [
            'view' => Actions\rest\ViewAction::className(),
            'update' => [
                'class' => Actions\rest\FormAction::className(),
                'model_class' => ProfileForm::className(),
                'model_files' => ['image'],
                'run_method' => 'update',
            ],
            'file-delete' => [
                'class' => Actions\rest\FileDeleteAction::className(),
                'allowed_attributes' => ['image'],
            ],
        ];
    }
    
    public function findModel($id)
    {
        return Yii::$app->user->identity;
    }
}
