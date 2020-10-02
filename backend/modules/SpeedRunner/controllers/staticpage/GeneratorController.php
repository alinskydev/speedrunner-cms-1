<?php

namespace backend\modules\Speedrunner\controllers\staticpage;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Schema;

use backend\modules\Speedrunner\forms\staticpage\GeneratorForm;


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
    
    public function actionNewPart($part_name, $part_index)
    {
        return $this->renderPartial('__new_part', [
            'part_name' => $part_name,
            'part_index' => $part_index,
        ]);
    }
    
    public function actionNewBlock($part_name, $part_index)
    {
        return $this->renderPartial('__new_block', [
            'part_name' => $part_name,
            'part_index' => $part_index,
        ]);
    }
    
    public function actionNewAttr($block)
    {
        return $this->renderPartial('__new_attr', [
            'block' => $block,
        ]);
    }
}
