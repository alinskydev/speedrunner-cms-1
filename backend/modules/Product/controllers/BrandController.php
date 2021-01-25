<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};

use backend\modules\Product\models\ProductBrand;
use backend\modules\Product\modelsSearch\ProductBrandSearch;


class BrandController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new ProductBrandSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new ProductBrand(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new ProductBrand(),
            ],
        ];
    }
    
    private function findModel()
    {
        return ProductBrand::findOne(Yii::$app->request->get('id'));
    }
}
