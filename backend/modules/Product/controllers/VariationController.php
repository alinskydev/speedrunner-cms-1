<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\ProductVariation;


class VariationController extends CrudController
{
    public function init()
    {
        $this->model = new ProductVariation();
        return parent::init();
    }
    
    public function actions()
    {
        return [
            'update' => [
                'class' => Actions\crud\UpdateAction::className(),
                'redirect_route' => false,
                'success_message' => false,
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
}
