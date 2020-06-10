<?php

namespace backend\modules\Product\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Product\models\Product;
use backend\modules\Product\modelsSearch\ProductSearch;
use backend\modules\Product\models\ProductImage;
use backend\modules\Product\models\ProductCategory;
use backend\modules\Product\models\ProductAttribute;
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
                $dataProvider[$key]->query->andWhere(['self.product_id' => $id]);
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
                'brand.translation', 'cats.translation', 'images',
                'related.translation', 'vars.attr', 'vars.option'
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
    
    public function actionGetSelectionList($q = '', $id = null)
    {
        $cond = $id ? ['!=', 'self.id', $id] : [];
        $out['results'] = Product::getSelectionList($q, 'name', $cond);
        return $this->asJson($out);
    }
    
    public function actionImageDelete()
    {
        if (($model = ProductImage::findOne(Yii::$app->request->post('key'))) && $model->delete()) {
            return true;
        }
    }
    
    public function actionImageSort($id)
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('sort');
            
            if ($post['oldIndex'] > $post['newIndex']){
                $params = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $counter = 1;
            } else {
                $params = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $counter = -1;
            }
            
            ProductImage::updateAllCounters(['sort' => $counter], [
               'and', ['item_id' => $id], $params
            ]);
            
            ProductImage::updateAll(['sort' => $post['newIndex']], [
                'id' => $post['stack'][$post['newIndex']]['key']
            ]);
            
            return true;
        }
    }
    
    public function actionGetAttributes($id, $categories)
    {
        $model = Product::findOne($id) ?: new Product;
        $categories = json_decode($categories, false);
        
        $attributes = ProductAttribute::find()
            ->alias('self')
            ->joinWith(['cats as cats'])
            ->with([
                'translation',
                'options.translation',
            ])
            ->where(['cats.id' => $categories])
            ->asArray()->all();
        
        $result['attrs_html'] = $this->renderPartial('_attributes', [
            'model' => $model,
            'attributes' => $attributes,
        ]);
        
        $result['attrs_json'] = $attributes;
        
        return json_encode($result, true);
    }
}
