<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\modelsSearch\ProductSpecificationSearch;


class SpecificationController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new ProductSpecificationSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new ProductSpecification(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new ProductSpecification(),
            ],
        ];
    }
    
    private function findModel()
    {
        return ProductSpecification::find()->with(['options'])->andWhere(['id' => $id])->one();
    }
}
