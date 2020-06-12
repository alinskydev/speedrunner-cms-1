<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $assignUrl array */
/* @var $removeUrl array */
/* @var $opts string */

$this->registerJs("var _opts = {$opts};", View::POS_BEGIN);
?>
<div class="row">
    <div class="col-lg-5">
        <input class="form-control search" data-target="available"
               placeholder="<?php echo Yii::t('yii2mod.rbac', 'Search for available'); ?>">
        <br/>
        <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>
    <div class="col-lg-2">
        <div class="move-buttons mx-0 py-5 text-center">
            <?php echo Html::a(
                Html::tag('i', null, ['class' => 'fas fa-angle-double-right']) . Yii::t('app', 'Include'),
                $assignUrl, [
                    'class' => 'btn btn-success btn-block btn-icon btn-assign my-3',
                    'data-target' => 'available',
                    'title' => Yii::t('yii2mod.rbac', 'Assign'),
                ]
            ); ?>
            
            <?php echo Html::a(
                Html::tag('i', null, ['class' => 'fas fa-angle-double-left']) . Yii::t('app', 'Exclude'),
                $removeUrl,
                [
                    'class' => 'btn btn-danger btn-block btn-icon btn-assign',
                    'data-target' => 'assigned',
                    'title' => Yii::t('yii2mod.rbac', 'Remove'),
                ]
            ); ?>
        </div>
    </div>
    <div class="col-lg-5">
        <input class="form-control search" data-target="assigned"
               placeholder="<?php echo Yii::t('yii2mod.rbac', 'Search for assigned'); ?>">
        <br/>
        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>