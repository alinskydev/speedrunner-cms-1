<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};
use common\helpers\Speedrunner\controller\actions\{ImageSortAction, ImageDeleteAction};

use backend\modules\Product\models\Product;
use backend\modules\Product\modelsSearch\ProductSearch;
use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\modelsSearch\ProductCommentSearch;
use backend\modules\Product\modelsSearch\ProductRateSearch;


class ProductController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new ProductSearch(),
            ],
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new Product(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
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
                'variations.specification', 'variations.option'
            ])
            ->andWhere(['id' => Yii::$app->request->get('id')])
            ->one();
        
        if ($model) {
            $model->related_tmp = $model->related;
            return $model;
        }
    }
    
    public function actionView($id)
    {
        if ($model = Product::findOne($id)) {
            $search_models = [
                'comments' => new ProductCommentSearch(),
                'rates' => new ProductRateSearch(),
            ];
            
            foreach ($search_models as $key => $s_m) {
                $modelSearch[$key] = $s_m;
                $dataProvider[$key] = $modelSearch[$key]->search(Yii::$app->request->queryParams);
                $dataProvider[$key]->pagination->pageParam = 'dp_' . $key;
                $dataProvider[$key]->pagination->pageSize = 20;
                $dataProvider[$key]->sort->sortParam = 'dp_' . $key . '-sort';
                $dataProvider[$key]->query->andWhere(['product_id' => $id]);
            }
            
            return $this->render('view', [
                'model' => $model,
                'modelSearch' => $modelSearch,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            $this->redirect(['index']);
        }
    }
    
    public function actionSpecifications($id = null, array $categories = [])
    {
        $model = Product::findOne($id) ?: new Product;
        $lang = Yii::$app->language;
        
        $specifications = ProductSpecification::find()
            ->joinWith([
                'categories',
                'options' => fn ($query) => $query->select(['*', new Expression("ProductSpecificationOption.name->>'$.$lang' as name")]),
            ])
            ->andWhere(['ProductCategory.id' => $categories])
            ->select([
                'ProductSpecification.*',
                new Expression("ProductSpecification.name->>'$.$lang' as name"),
                'ProductSpecificationOption.sort',
            ])
            ->groupBy('ProductSpecification.id')
            ->asArray()->all();
        
        $variations = [
            'items' => ArrayHelper::map($specifications, 'id', 'name'),
            'data_options' => [],
        ];
        
        foreach ($specifications as $s) {
            $options = Html::renderSelectOptions(null, ArrayHelper::map($s['options'], 'id', 'name'));
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
