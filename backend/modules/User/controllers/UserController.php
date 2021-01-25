<?php

namespace backend\modules\User\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\User\models\User;
use backend\modules\User\modelsSearch\UserSearch;


class UserController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new UserSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new User(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new User(),
            ],
        ];
    }
    
    private function findModel()
    {
        return User::findOne(Yii::$app->request->get('id'));
    }
}
