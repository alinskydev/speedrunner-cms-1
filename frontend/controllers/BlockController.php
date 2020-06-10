<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use backend\modules\Block\models\BlockPage;
use backend\modules\Block\models\Block;


class BlockController extends Controller
{
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'enabled' => Yii::$app->settings->use_frontend_cache,
                'duration' => 0,
                'variations' => [
                    Yii::$app->language,
                    Yii::$app->user,
                    Yii::$app->request->get('url'),
                ],
            ],
        ];
    }
    
    public function actionView($url)
    {
        if ($model = BlockPage::find()->with(['translation'])->where(['url' => $url])->one()) {
            $blocks = Block::find()
                ->with([
                    'translation', 'type', 'images'
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
