<?php

namespace common\helpers\SpeedRunner;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\StaticPage\models\StaticPage;


class Record
{
    private $redirect_url;
    
    public function __construct()
    {
        $this->redirect_url = Yii::$app->request->absoluteUrl != Yii::$app->request->referrer ? Yii::$app->request->referrer : ['index'];
    }
    
    public function dataProvider($modelSearch, $render_file = 'index', $render_params = [])
    {
        $render_params['modelSearch'] = $modelSearch;
        $render_params['dataProvider'] = $modelSearch->search(Yii::$app->request->queryParams);
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        
        return Yii::$app->controller->{$render_type}($render_file, $render_params);
    }
    
    public function updateModel($model, $render_file = 'update', $render_params = [])
    {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return Yii::$app->controller->redirect($this->redirect_url);
        }
        
        $render_type = (Yii::$app->request->isPost && Yii::$app->request->isAjax) ? 'renderAjax' : 'render';
        $render_params['model'] = $model;
        
        return Yii::$app->controller->{$render_type}($render_file, $render_params);
    }
    
    public function deleteModel($model)
    {
        $id = Yii::$app->request->post('selection') ?: Yii::$app->request->get('id');
        $models = $model->find()->where(['id' => $id])->all();
        
        foreach ($models as $m) {
            $m->delete();
        }
        
        return Yii::$app->controller->redirect($this->redirect_url);
    }
    
    public function getStaticPage($location, $with_blocks = false)
    {
        if ($with_blocks) {
            $result['page'] = StaticPage::find()->with(['blocks'])->where(['location' => $location])->one();
            $result['blocks'] = ArrayHelper::index($result['page']->blocks, 'name');
        } else {
            $result['page'] = StaticPage::find()->where(['location' => $location])->one();
            $result['blocks'] = [];
        }
        
        return $result;
    }
}
