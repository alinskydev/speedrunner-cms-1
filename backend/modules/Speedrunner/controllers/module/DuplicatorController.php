<?php

namespace backend\modules\Speedrunner\controllers\module;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\Speedrunner\forms\module\DuplicatorForm;


class DuplicatorController extends Controller
{
    public function actionIndex()
    {
        $model = new DuplicatorForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->process()) {
                Yii::$app->session->addFlash('success', 'Succeccfully done');
            } else {
                Yii::$app->session->addFlash('danger', 'An error occured');
            }
            
            return $this->refresh();
        }
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
