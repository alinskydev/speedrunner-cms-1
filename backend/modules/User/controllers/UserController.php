<?php

namespace backend\modules\User\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\User\models\User;
use backend\modules\User\modelsSearch\UserSearch;


class UserController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new UserSearch(),
            ],
            'create' => [
                'class' => Actions\UpdateAction::className(),
                'model' => new User(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new User(),
            ],
        ];
    }
    
    private function findModel()
    {
        return User::findOne(Yii::$app->request->get('id'));
    }
}
