<?php

namespace backend\modules\SpeedRunner\controllers\module;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Schema;

use backend\modules\SpeedRunner\forms\module\DuplicatorForm;


class DuplicatorController extends Controller
{
    public function actionIndex()
    {
        $model = new DuplicatorForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->duplicate()) {
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
