<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\actions\web\{IndexAction, ViewAction, UpdateAction, DeleteAction};
use common\actions\web\{ImageSortAction, ImageDeleteAction};

use backend\modules\Product\models\Product;
use backend\modules\Product\modelsSearch\ProductSearch;
use backend\modules\Product\models\ProductCategory;
use backend\modules\Product\models\ProductSpecification;


class ProductController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new ProductSearch(),
                'params' => [
                    'categories_list' => ProductCategory::find()->itemsTree('name', 'translation')->andWhere('depth > 0')->asArray()->all(),
                ],
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new Product(),
                'params' => [
                    'categories_list' => ProductCategory::find()->itemsTree('name', 'translation')->andWhere('depth > 0')->asArray()->all(),
                ],
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
                'params' => [
                    'categories_list' => ProductCategory::find()->itemsTree('name', 'translation')->andWhere('depth > 0')->asArray()->all(),
                ],
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new Product(),
            ],
            'image-sort' => [
                'class' => ImageSortAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['images'],
            ],
            'image-delete' => [
                'class' => ImageDeleteAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['images'],
            ],
        ];
    }
    
    private function findModel()
    {
        $model = Product::find()
            ->with([
                'brand', 'categories',
                'variations.specification', 'variations.option',
            ])
            ->andWhere(['id' => Yii::$app->request->get('id')])
            ->one();
        
        if ($model) {
            $model->related_tmp = $model->related;
            return $model;
        }
    }
    
    public function actionSpecifications($id = null, array $categories = [])
    {
        $model = Product::findOne($id) ?: new Product;
        $specifications = ProductSpecification::find()->assignedToCategies($categories)->asArray()->all();
        
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
