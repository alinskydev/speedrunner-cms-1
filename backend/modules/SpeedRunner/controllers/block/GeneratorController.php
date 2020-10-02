<?php

namespace backend\modules\Speedrunner\controllers\block;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Schema;

use backend\modules\Speedrunner\forms\block\GeneratorForm;


class GeneratorController extends Controller
{
    public function actionIndex()
    {
        $model = new GeneratorForm;
        
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
    
    public function actionNewAttr($block)
    {
        return $this->renderPartial('_new_attr', [
            'block' => $block,
        ]);
    }
}
