<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

use backend\modules\Product\models\Product;
use backend\modules\Product\modelsSearch\ProductSearch;
use backend\modules\Product\models\ProductCategory;
use backend\modules\Product\models\ProductAttribute;
use backend\modules\Product\models\ProductAttributeOption;
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
                'brand', 'cats',
                'vars.attr', 'vars.option'
            ])
            ->where(['id' => $id])
            ->one();
        
        if ($model) {
            $model->cats_tmp = json_encode(ArrayHelper::getColumn($model->cats, 'id'));
            
            return Yii::$app->sr->record->updateModel($model);
        } else {
            return $this->redirect(['index']);
        }
    }
    
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new Product);
    }
    
    public function actionItemsList($q = '', $id = null)
    {
        $cond = $id ? ['!=', 'id', $id] : [];
        $out['results'] = Product::itemsList('name', 'translation', 20, $q, $cond);
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
    
    public function actionGetAttributes($id, $categories)
    {
        $model = Product::findOne($id) ?: new Product;
        $categories = json_decode($categories, false);
        $lang = Yii::$app->language;
        
        $attributes = ProductAttribute::find()
            ->alias('self')
            ->joinWith([
                'cats as cats',
                'options as options' => function ($query) use ($lang) {
                    $query->select(['*', new Expression("options.name->>'$.$lang' as name")]);
                },
            ])
            ->where(['cats.id' => $categories])
            ->select([
                'self.*',
                new Expression("self.name->>'$.$lang' as name"),
                'options.sort',
            ])
            ->distinct()
            ->asArray()->all();
        
        $result['json'] = $attributes;
        $result['html'] = $this->renderPartial('_attributes', [
            'model' => $model,
            'attributes' => $attributes,
        ]);
        
        return $this->asJson($result);
    }
}
