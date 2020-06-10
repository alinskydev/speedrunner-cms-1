<?= '<?php' ?>


namespace backend\modules\<?= $model->module_name ?>;


class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\<?= $model->module_name ?>\controllers';
    public $defaultRoute = '<?= strtolower($model->controller_name) ?>';
    
    public function init()
    {
        parent::init();
    }
}
