<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web as Actions;

use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\modelsSearch\ProductSpecificationSearch;


class SpecificationController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => Actions\IndexAction::className(),
                'modelSearch' => new ProductSpecificationSearch(),
            ],
            'create' => [
                'class' => Actions\UpdateAction::className(),
                'model' => new ProductSpecification(),
            ],
            'update' => [
                'class' => Actions\UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => Actions\DeleteAction::className(),
                'model' => new ProductSpecification(),
            ],
        ];
    }
    
    private function findModel()
    {
        return ProductSpecification::find()->with(['options'])->andWhere(['id' => Yii::$app->request->get('id')])->one();
    }
}
