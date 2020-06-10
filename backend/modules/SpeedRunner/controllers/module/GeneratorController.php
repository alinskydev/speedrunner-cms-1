<?php

namespace backend\modules\SpeedRunner\controllers\module;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\db\Schema;

use backend\modules\SpeedRunner\forms\module\GeneratorForm;


class GeneratorController extends Controller
{
    public $dbSchema;
    
    public function beforeAction($action)
    {
        $this->dbSchema = Yii::$app->db->schema;
        
        return parent::beforeAction($action);
    }
    
    public function actionIndex()
    {
        $model = new GeneratorForm;
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->generate()) {
                Yii::$app->session->setFlash('success', 'Succeccfully done');
            } else {
                Yii::$app->session->setFlash('danger', 'Error');
            }
            
            return $this->refresh();
        }
        
        foreach ($this->dbSchema->getTableNames() as $t) {
            if (strpos($t, 'Translation') === false) {
                $tables[$t] = $t;
            }
        }
            
        return $this->render('index', [
            'model' => $model,
            'tables' => $tables,
        ]);
    }
    
    public function actionAttrsFields()
    {
        $table_name = Yii::$app->request->post('table_name');
        $columns = $this->dbSchema->getTableSchema($table_name)->columns;
        
        if ($with_translation = Yii::$app->request->post('with_translation')) {
            $translation_attrs = ['item_id', 'lang'];
            
            $columns_translation = $this->dbSchema->getTableSchema($table_name . 'Translation')->columns;
            
            foreach ($translation_attrs as $t_a) {
                unset($columns_translation[$t_a]);
            }
            
            $columns = ArrayHelper::merge($columns_translation, $columns);
        }
        
        return $this->renderAjax('_attr_fields', [
            'model' => new GeneratorForm,
            'table_name' => $table_name,
            'columns' => $columns,
        ]);
    }
}
