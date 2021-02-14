<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductVariation;


class VariationController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new ProductVariation();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
        return [
            'update' => [
                'class' => Actions\crud\UpdateAction::className(),
                'redirect_route' => false,
            ],
            'file-sort' => [
                'class' => Actions\crud\FileSortAction::className(),
                'allowed_attributes' => ['images'],
            ],
            'file-delete' => [
                'class' => Actions\crud\FileDeleteAction::className(),
                'allowed_attributes' => ['images'],
            ],
        ];
    }
    
    public function findModel()
    {
        return ProductVariation::findOne(Yii::$app->request->get('id'));
    }
}
