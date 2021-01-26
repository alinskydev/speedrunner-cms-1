<?php

namespace backend\modules\Block\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Block\models\BlockType;
use backend\modules\Block\modelsSearch\BlockTypeSearch;


class TypeController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new BlockTypeSearch(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
        ];
    }
    
    private function findModel()
    {
        return BlockType::findOne(Yii::$app->request->get('id'));
    }
}
