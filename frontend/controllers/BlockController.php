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
        if ($model = BlockPage::find()->where(['slug' => $slug])->one()) {
            return $this->render('view', [
                'model' => $model,
                'blocks' => Block::find()->with(['type'])->where(['page_id' => $model->id])->orderBy('sort')->all(),
            ]);
        } else {
            $this->redirect(['site/index']);
        }
    }
}
