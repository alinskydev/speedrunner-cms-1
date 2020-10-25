<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

use backend\modules\User\models\User;


class ProfileController extends Controller
{
    protected $user;
    
    protected $forms = [
        'update' => '\frontend\forms\ProfileForm',
    ];
    
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBasicAuth::className(),
            ],
            'format' => [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formatParam' => 'format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'text/xml' => Response::FORMAT_XML,
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'update' => ['post'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->user = User::findOne(Yii::$app->user->id);
        return true;
    }
    
    public function actionIndex()
    {
        return $this->user;
    }
    
    public function actionUpdate()
    {
        $model = new $this->forms['update'](['user' => $this->user]);
        $model->load([$model->formName() => Yii::$app->request->post()]);
        
        if (isset($_FILES['image'])) {
            foreach ($_FILES['image'] as $key => $f) {
                $_FILES[$model->formName()][$key]['image'] = $f;
            }
            
            unset($_FILES['image']);
        }
        
        if ($model->validate()) {
            $model->update();
            $this->user->refresh();
            
            return [
                'access_token' => Yii::$app->user->identity->auth_key,
            ];
        } else {
            Yii::$app->response->statusCode = 422;
            
            return [
                'name' => 'Unprocessable entity',
                'message' => $model->errors,
                'code' => 0,
                'status' => 422,
                'type' => 'yii\\web\\UnprocessableEntityHttpException',
            ];
        }
    }
}
