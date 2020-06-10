<?php

namespace backend\modules\SpeedRunner\controllers\api;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\modules\SpeedRunner\forms\api\GeneratorForm;


class GeneratorController extends Controller
{
    public function actionIndex()
    {
        //        FORM
        
        $model = new GeneratorForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->generate()) {
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
