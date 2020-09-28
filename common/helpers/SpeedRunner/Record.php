<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\Staticpage\models\Staticpage;


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
            if (Yii::$app->request->get('reload-page')) {
                return Yii::$app->controller->redirect(['update', 'id' => $model->id]);
            } else {
                return Yii::$app->controller->redirect(['index']);
            }
        }
        
        $render_type = Yii::$app->request->isAjax ? 'renderAjax' : 'render';
        $render_params['model'] = $model;
        
        return Yii::$app->controller->{$render_type}($render_file, $render_params);
    }
    
    public function deleteModel($model)
    {
        $id = Yii::$app->request->post('selection') ?: Yii::$app->request->get('id');
        $models = $model->find()->andWhere(['id' => $id])->all();
        
        foreach ($models as $m) {
            $m->delete();
        }
        
        return Yii::$app->controller->redirect($this->redirect_url);
    }
    
    public function staticpage($location)
    {
        $result['page'] = Staticpage::find()->with(['blocks'])->andWhere(['location' => $location])->one();
        $result['blocks'] = ArrayHelper::map($result['page']->blocks, 'name', 'value');
        
        return $result;
    }
}
