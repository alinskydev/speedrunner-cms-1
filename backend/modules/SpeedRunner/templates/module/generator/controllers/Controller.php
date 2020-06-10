<?php

$use = isset($model->use['controller']) ? $model->use['controller'] : [];
$controller_default_actions = ['index', 'view', 'create', 'update', 'delete'];
$controller_extra_actions = array_diff($model->controller_actions, $controller_default_actions);

echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
<?php foreach ($use as $u) { ?>
use <?= $u['value'] ?>;
<?php } ?>

use backend\modules\<?= $model->module_name ?>\models\<?= $model->table_name ?>;
use backend\modules\<?= $model->module_name ?>\modelsSearch\<?= $model->table_name ?>Search;


class <?= $model->controller_name ?>Controller extends Controller
{
<?php if (in_array('index', $model->controller_actions)) { ?>
    public function actionIndex()
    {
        return Yii::$app->sr->record->dataProvider(new <?= $model->table_name ?>Search);
    }
    
<?php } ?>
<?php if (in_array('view', $model->controller_actions)) { ?>
    public function actionView($id)
    {
        if ($model = <?= $model->table_name ?>::findOne($id)) {
            return $this->render('view', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['index']);
        }
    }
    
<?php } ?>
<?php if (in_array('create', $model->controller_actions)) { ?>
    public function actionCreate()
    {
        return Yii::$app->sr->record->updateModel(new <?= $model->table_name ?>);
    }
    
<?php } ?>
<?php if (in_array('update', $model->controller_actions)) { ?>
    public function actionUpdate($id)
    {
        $model = <?= $model->table_name ?>::findOne($id);
        return $model ? Yii::$app->sr->record->updateModel($model) : $this->redirect(['index']);
    }
    
<?php } ?>
<?php if (in_array('delete', $model->controller_actions)) { ?>
    public function actionDelete()
    {
        return Yii::$app->sr->record->deleteModel(new <?= $model->table_name ?>);
    }
<?php } ?>
<?php foreach ($controller_extra_actions as $action) { ?>
    
    public function action<?= ucfirst($action) ?>()
    {
        
    }
<?php } ?>
}
