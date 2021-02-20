<?php

use yii\helpers\ArrayHelper;

$attrs_fields = ArrayHelper::index($model->attrs_fields, null, 'type');


echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\<?= $model->module_name ?>\models\<?= $model->model_name ?>;


class <?= $model->controller_name ?>Controller extends CrudController
{
    public function init()
    {
        $this->model = new <?= $model->model_name ?>();
        return parent::init();
    }
    
    public function actions()
    {
<?php if (isset($attrs_fields['files'])) { ?>
<?php $file_attrs = ArrayHelper::getColumn($attrs_fields['files'], 'name'); ?>
        $actions = ArrayHelper::filter(parent::actions(), ['<?= implode("', '", $model->controller_actions) ?>']);
        
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
        return ArrayHelper::filter(parent::actions(), ['<?= implode("', '", $model->controller_actions) ?>']);
<?php } ?>
    }
}
