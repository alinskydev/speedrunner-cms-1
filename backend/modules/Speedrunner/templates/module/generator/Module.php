<?= '<?php' ?>


namespace backend\modules\<?= $model->module_name ?>;


class Module extends \yii\base\Module
{
    public $defaultRoute = '<?= strtolower($model->controller_name) ?>';
}
