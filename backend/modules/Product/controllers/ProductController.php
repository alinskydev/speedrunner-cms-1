<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

use backend\modules\Product\models\Product;
use backend\modules\Product\modelsSearch\ProductSearch;
use backend\modules\Product\models\ProductSpecification;
use backend\modules\Product\modelsSearch\ProductCommentSearch;
use backend\modules\Product\modelsSearch\ProductRateSearch;


class ProductController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new ProductSearch);
    }
    
    public function actionView($id)
    {
        if ($model = Product::findOne($id)) {
            $search_models = [
                'comments' => new ProductCommentSearch,
                'rates' => new ProductRateSearch
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
    
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new Product);
    }
    
    public function actionUpdate($id)
    {
        $model = Product::find()
            ->with([
                'brand', 'categories',
                'variations.specification', 'variations.option'
            ])
            ->where(['id' => $id])
            ->one();
        
        if ($model) {
            $model->categories_tmp = json_encode(ArrayHelper::getColumn($model->categories, 'id'));
            $model->related_tmp = ArrayHelper::getColumn($model->related, 'id');
            
            return Yii::$app->sr->record->updateModel($model);
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Product);
    }
    
    public function actionItemsList($q = null, $id = null)
    {
        $out['results'] = Product::itemsList('name', 'translation', $q)->andFilterWhere(['!=', 'id', $id])->asArray()->all();
        return $this->asJson($out);
    }
    
    public function actionImageDelete($id)
    {
        if (!($model = Product::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->images;
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes(['images' => array_values($images)]);
        }
    }
    
    public function actionImageSort($id)
    {
        if (!($model = Product::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->images;
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes(['images' => array_values($images)]);
    }
    
    public function actionSpecifications($id, $categories)
    {
        $model = Product::findOne($id) ?: new Product;
        $categories = json_decode($categories, JSON_UNESCAPED_UNICODE);
        $lang = Yii::$app->language;
        
        $specifications = ProductSpecification::find()
            ->joinWith([
                'categories',
                'options' => function ($query) use ($lang) {
                    $query->select(['*', new Expression("ProductSpecificationOption.name->>'$.$lang' as name")]);
                },
            ])
            ->where(['ProductCategory.id' => $categories])
            ->select([
                'ProductSpecification.*',
                new Expression("ProductSpecification.name->>'$.$lang' as name"),
                'ProductSpecificationOption.sort',
            ])
            ->distinct()
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
