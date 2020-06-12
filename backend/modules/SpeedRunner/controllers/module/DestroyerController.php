<?php

namespace backend\modules\SpeedRunner\controllers\module;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\SpeedRunner\forms\module\DestroyerForm;


class DestroyerController extends Controller
{
    public function actionIndex()
    {
        $model = new DestroyerForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->destroy()) {
                Yii::$app->session->setFlash('success', 'Succeccfully done');
            } else {
                Yii::$app->session->setFlash('danger', 'Error');
            }
            
            return $this->refresh();
        }
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
