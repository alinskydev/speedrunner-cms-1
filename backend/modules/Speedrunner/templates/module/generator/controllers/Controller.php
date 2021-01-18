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
use common\helpers\Speedrunner\controller\actions\{IndexAction, ViewAction, UpdateAction, DeleteAction};
<?php if (isset($attrs_fields['images'])) { ?>
use common\helpers\Speedrunner\controller\actions\{ImageSortAction, ImageDeleteAction};
<?php } ?>

use backend\modules\<?= $model->module_name ?>\models\<?= $model->table_name ?>;
use backend\modules\<?= $model->module_name ?>\modelsSearch\<?= $model->table_name ?>Search;


class <?= $model->controller_name ?>Controller extends Controller
{
    public function actions()
    {
        return [
<?php if (in_array('index', $model->controller_actions)) { ?>
            'index' => [
                'class' => IndexAction::className(),
                'modelSearch' => new BlogCategorySearch(),
            ],
<?php } ?>
<?php if (in_array('view', $model->controller_actions)) { ?>
            'view' => [
                'class' => ViewAction::className(),
                'model' => $this->findModel(),
            ],
<?php } ?>
<?php if (in_array('create', $model->controller_actions)) { ?>
            'create' => [
                'class' => UpdateAction::className(),
                'model' => new BlogCategory(),
            ],
<?php } ?>
<?php if (in_array('update', $model->controller_actions)) { ?>
            'update' => [
                'class' => UpdateAction::className(),
                'model' => $this->findModel(),
            ],
<?php } ?>
<?php if (in_array('delete', $model->controller_actions)) { ?>
            'delete' => [
                'class' => DeleteAction::className(),
                'model' => new BlogCategory(),
            ],
<?php } ?>
<?php if (isset($attrs_fields['images'])) { ?>
<?php $image_attrs = ArrayHelper::getColumn($attrs_fields['images'], 'name'); ?>
            'image-sort' => [
                'class' => ImageSortAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['<?= implode("', '", $image_attrs) ?>'],
            ],
            'image-delete' => [
                'class' => ImageDeleteAction::className(),
                'model' => $this->findModel(),
                'allowed_attributes' => ['<?= implode("', '", $image_attrs) ?>'],
            ],
<?php } ?>
        ];
    }
<?php if (in_array('view', $model->controller_actions) || in_array('update', $model->controller_actions)) { ?>
    
    private function findModel()
    {
        return <?= $model->table_name ?>::findOne(Yii::$app->request->get('id'));
    }
<?php } ?>
<?php foreach ($controller_extra_actions as $action) { ?>
    
    public function action<?= ucfirst($action) ?>()
    {
        
    }
<?php } ?>
}
