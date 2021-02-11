<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\models\Block;


class BlockController extends Controller
{
    public function actionView($slug)
    {
        if (!($model = BlockPage::find()->with(['blocks.type'])->bySlug($slug)->one())) {
            $this->redirect(['site/index']);
        }
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
