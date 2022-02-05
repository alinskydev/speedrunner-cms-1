<?php

namespace backend\modules\Product\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\Product;
use backend\modules\Product\models\ProductCategory;
use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\models\ProductVariation;


class ProductController extends CrudController
{
    public function init()
    {
        $this->model = new Product();
        return parent::init();
    }

    public function actions()
    {
        $actions = ArrayHelper::filter(parent::actions(), ['delete']);

        return ArrayHelper::merge($actions, [
            'index' => [
                'class' => Actions\crud\DataProviderAction::className(),
                'render_params' => fn () => [
                    'categories' => ProductCategory::find()->itemsTree('name', 'translation')->withoutRoots()->asArray()->all(),
                ],
            ],
            'create' => [
                'class' => Actions\crud\CreateAction::className(),
                'render_params' => fn () => [
                    'categories' => [
                        'list' => ProductCategory::find()->itemsTree('name', 'translation')->withoutRoots()->asArray()->all(),
                        'tree' => ProductCategory::findOne(1)->tree(),
                    ],
                ],
            ],
            'update' => [
                'class' => Actions\crud\UpdateAction::className(),
                'render_params' => fn () => [
                    'categories' => [
                        'list' => ProductCategory::find()->itemsTree('name', 'translation')->withoutRoots()->asArray()->all(),
                        'tree' => ProductCategory::findOne(1)->tree(),
                    ],
                ],
            ],
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
        return $this->model->find()->with(['categories', 'variations'])->andWhere(['id' => $id])->one();
    }

    public function actionSpecifications($id = null, array $categories = [])
    {
        $model = $this->model->findOne($id) ?: $this->model;
        $specifications = ProductSpecification::find()->byAssignedCategies($categories)->asObject()->all();

        return $this->asJson([
            'specifications' => $this->renderPartial('_specifications', [
                'specifications' => $specifications,
                'options' => ArrayHelper::getColumn($model->options, 'id'),
            ]),
        ]);
    }
}
