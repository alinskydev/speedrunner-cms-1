<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use common\controllers\RestController as Controller;
use common\actions\rest as Actions;

use backend\modules\User\models\User;


class ProfileController extends Controller
{
    const FORMS = [
        'update' => '\frontend\forms\ProfileForm',
    ];
    
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
                'class' => Actions\FormAction::className(),
                'run_method' => 'update',
                'file_attributes' => ['image'],
            ],
        ];
    }
    
    public function actionInformation()
    {
        return Yii::$app->user->identity;
    }
}
