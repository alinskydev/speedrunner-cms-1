<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductSpecification;


class ProductController extends CrudController
{
    public function init()
    {
        $this->model = new Product();
        return parent::init();
    }
    
    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
        
        return ArrayHelper::merge($actions, [
            'file-sort' => [
                'class' => Actions\crud\FileSortAction::className(),
                'allowed_attributes' => ['images'],
            ],
            'file-delete' => [
                'class' => Actions\crud\FileDeleteAction::className(),
                'allowed_attributes' => ['images'],
            ],
        ]);
    }
    
    public function findModel($id)
    {
        return $this->model->find()->with(['categories', 'variations.specification', 'variations.option'])->andWhere(['id' => $id])->one();
    }
    
    public function actionSpecifications($id = null, array $categories = [])
    {
        $model = $this->model->findOne($id) ?: $this->model;
        $specifications = ProductSpecification::find()->byAssignedCategies($categories)->asArray()->all();
        
        $variations = [
            'items' => ArrayHelper::map($specifications, 'id', 'name'),
            'data_options' => [],
        ];
        
        foreach ($specifications as $s) {
            $variations['data_options']['options'][$s['id']] = [
                'data-options' => Html::renderSelectOptions(null, ArrayHelper::map($s['options'], 'id', 'name')),
            ];
        }
        
        return $this->asJson([
            'specifications' => $this->renderPartial('_specifications', [
                'specifications' => $specifications,
                'options' => ArrayHelper::getColumn($model->options, 'id'),
            ]),
            'variations' => Html::renderSelectOptions(null, $variations['items'], $variations['data_options']),
        ]);
    }
}
