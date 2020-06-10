<?php

$index_title = ($model->module_name == $model->controller_name) ? $model->module_name : $model->module_name . ' ' . $model->controller_name;

//      ATTRIBUTES

$attrs = $model->attrs_fields ?: [];

echo '<?php';

?>


use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'View: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '<?= $index_title ?>s'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<h2 class="main-title">
    <?= "<?= \$this->title ?>\n" ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= "<?= Yii::t('app', 'General') ?>\n" ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <?= '<?= ' ?>DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-bordered m-0'],
                    'attributes' => [
<?php foreach ($attrs as $key => $a) { ?>
                        '<?= $key ?>',
<?php } ?>
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
