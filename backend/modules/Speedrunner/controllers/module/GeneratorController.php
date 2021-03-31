<?php

namespace backend\modules\Speedrunner\controllers\module;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

use backend\modules\Speedrunner\forms\module\GeneratorForm;


class GeneratorController extends Controller
{
    public function actionIndex()
    {
        $model = new GeneratorForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->process()) {
                Yii::$app->session->addFlash('success', 'Successfully done');
            } else {
                Yii::$app->session->addFlash('danger', 'An error occurred');
            }
            
            return $this->refresh();
        }
        
        foreach (Yii::$app->db->schema->getTableNames() as $t) {
            $tables[$t] = $t;
        }
            
        return $this->render('index', [
            'model' => $model,
            'tables' => $tables,
        ]);
    }
    
    public function actionModelSchema($table_name)
    {
        //        Relations
        
        $table_schema_all = ArrayHelper::index(Yii::$app->db->schema->getTableSchemas(), 'name');
        $table_schema = ArrayHelper::getValue($table_schema_all, $table_name);
        
        if (!$table_schema) {
            return false;
        }
        
        $foreign_keys['internal'] = ArrayHelper::index($table_schema->foreignKeys, 0);
        $foreign_keys['external'] = ArrayHelper::map($table_schema_all, 'name', function ($value) use ($table_name) {
            foreach ($value->foreignKeys as $fk) {
                if ($fk[0] == $table_name) {
                    return $fk;
                }
            }
        });
        
        $foreign_keys['external'] = array_filter($foreign_keys['external']);
        
        $data['relations'] = $this->renderAjax('_model_relations', [
            'table_name' => Inflector::id2camel($table_name, '_'),
            'foreign_keys' => $foreign_keys,
        ]);
        
        //        Attributes
        
        $columns = $table_schema->columns;
        
        $data['attrs'] = $this->renderAjax('_attr_fields', [
            'model' => new GeneratorForm(),
            'table_name' => $table_name,
            'columns' => $columns,
        ]);
        
        return $this->asJson($data);
    }
}
