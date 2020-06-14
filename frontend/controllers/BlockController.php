<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\models\Block;


class BlockController extends Controller
{
    public function actionView($url)
    {
        if ($model = BlockPage::find()->where(['url' => $url])->one()) {
            $blocks = Block::find()
                ->with([
                    'type', 'images'
                ])
                ->where(['page_id' => $model->id])
                ->orderBy('sort')
                ->all();
            
            return $this->render('view', [
                'model' => $model,
                'blocks' => $blocks,
            ]);
        } else {
            $this->redirect(['site/index']);
        }
    }
}
