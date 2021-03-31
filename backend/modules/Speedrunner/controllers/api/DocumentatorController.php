<?php

namespace backend\modules\Speedrunner\controllers\api;

use Yii;
use yii\web\Controller;

use backend\modules\Speedrunner\forms\api\DocumentatorForm;


class DocumentatorController extends Controller
{
    public function actionIndex()
    {
        $model = new DocumentatorForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->process()) {
                Yii::$app->session->addFlash('success', 'Successfully done');
            } else {
                Yii::$app->session->addFlash('danger', 'An error occurred');
            }
            
            return $this->refresh();
        }
        
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
