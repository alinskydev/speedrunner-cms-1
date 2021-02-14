<?php

use yii\helpers\ArrayHelper;

$attrs_fields = ArrayHelper::index($model->attrs_fields, null, 'type');


echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\controllers;

use Yii;
use common\controllers\CrudController;
use common\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\<?= $model->module_name ?>\models\<?= $model->table_name ?>;
use backend\modules\<?= $model->module_name ?>\search\<?= $model->table_name ?>Search;


class <?= $model->controller_name ?>Controller extends CrudController
{
    public function beforeAction($action)
    {
        $this->model = new <?= $model->table_name ?>();
        $this->modelSearch = new <?= $model->table_name ?>Search();
        
        return parent::beforeAction($action);
    }
    
    public function actions()
    {
<?php if (isset($attrs_fields['files'])) { ?>
<?php $file_attrs = ArrayHelper::getColumn($attrs_fields['files'], 'name'); ?>
        $actions = ArrayHelper::filter(parent::actions(), [<?= implode("', '", $model->controller_actions) ?>]);
        
        return ArrayHelper::merge($actions, [
            'file-sort' => [
                'class' => Actions\crud\FileSortAction::className(),
                'allowed_attributes' => ['<?= implode("', '", $file_attrs) ?>'],
            ],
            'file-delete' => [
                'class' => Actions\crud\FileDeleteAction::className(),
                'allowed_attributes' => ['<?= implode("', '", $file_attrs) ?>'],
            ],
        ]);
<?php } else { ?>
        return ArrayHelper::filter(parent::actions(), [<?= implode("', '", $model->controller_actions) ?>]);
<?php } ?>
    }
<?php if (in_array('view', $model->controller_actions) || in_array('update', $model->controller_actions)) { ?>
    
    public function findModel()
    {
        return <?= $model->table_name ?>::findOne(Yii::$app->request->get('id'));
    }
<?php } ?>
}
