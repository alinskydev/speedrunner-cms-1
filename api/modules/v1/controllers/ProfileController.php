<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;

use api\modules\v1\models\User;


class ProfileController extends Controller
{
    protected $user;
    
    static $forms = [
        'update' => '\frontend\forms\ProfileForm',
    ];
    
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBasicAuth::className(),
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
                'class' => VerbFilter::className(),
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
//        if (isset($_FILES['image'])) {
//            foreach ($_FILES['image'] as $key => $f) {
//                $_FILES['ProfileForm'][$key]['image'] = $f;
//            }
//            
//            unset($_FILES['image']);
//        }
        
        $model = new $this->forms['update'](['user' => $this->user]);
        $model->load(['ProfileForm' => Yii::$app->request->post()]);
        
        if ($model->validate()) {
            $model->update();
            
            return [
                'errors' => null,
                'access-token' => User::findOne($this->user->id)->auth_key
            ];
        } else {
            return ['errors' => $model->errors];
        }
    }
}
