<?php

use yii\helpers\ArrayHelper;

$controller_default_actions = ['index', 'view', 'create', 'update', 'delete'];
$controller_extra_actions = array_diff($model->controller_actions, $controller_default_actions);
$attrs_fields = ArrayHelper::index($model->attrs_fields, null, 'type');


echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
<?php if (isset($attrs_fields['images'])) { ?>
<?php $image_attrs = ArrayHelper::getColumn($attrs_fields['images'], 'name') ?>
    
    public function actionImageSort($id, $attr)
    {
        if (!in_array($attr, ['<?= implode("', '", $image_attrs) ?>'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = <?= $model->table_name ?>::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->{$attr};
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');
        
        return $model->updateAttributes([$attr => array_values($images)]);
    }
    
    public function actionImageDelete($id, $attr)
    {
        if (!in_array($attr, ['<?= implode("', '", $image_attrs) ?>'])) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        if (!($model = <?= $model->table_name ?>::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        
        $images = $model->{$attr};
        $key = array_search(Yii::$app->request->post('key'), $images);
        
        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);
            
            return $model->updateAttributes([$attr => array_values($images)]);
        }
    }
<?php } ?>
<?php foreach ($controller_extra_actions as $action) { ?>
    
    public function action<?= ucfirst($action) ?>()
    {
        
    }
<?php } ?>
}
