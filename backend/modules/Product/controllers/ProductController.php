<?php

namespace backend\modules\Product\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use backend\modules\Product\models\Product;
use backend\modules\Product\modelsSearch\ProductSearch;
use backend\modules\Product\models\ProductSpecification;


class ProductController extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new Product();
        $this->modelSearch = new ProductSearch();
        
        return parent::beforeAction($action);
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
    
    public function findModel()
    {
        return Product::find()
            ->with([
                'categories',
                'variations.specification', 'variations.option',
            ])
            ->andWhere(['id' => Yii::$app->request->get('id')])
            ->one();
    }
    
    public function actionSpecifications($id = null, array $categories = [])
    {
        $model = Product::findOne($id) ?: new Product;
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
