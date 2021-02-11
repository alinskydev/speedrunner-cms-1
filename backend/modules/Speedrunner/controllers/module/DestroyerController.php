<?php

namespace backend\modules\Speedrunner\controllers\module;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\Speedrunner\forms\module\DestroyerForm;


class DestroyerController extends Controller
{
    public function actionIndex()
    {
        $model = new DestroyerForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->process()) {
                Yii::$app->session->setFlash('success', ['Successfully done']);
            } else {
                Yii::$app->session->setFlash('danger', ['An error occurred']);
            }
            
            return $this->refresh();
        }
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
