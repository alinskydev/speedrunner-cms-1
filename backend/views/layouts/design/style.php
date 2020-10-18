<?php

use yii\helpers\ArrayHelper;

$border_radius = ArrayHelper::getValue(Yii::$app->user->identity, 'design_border_radius', 0);

?>

<style>
    .main-shadow,
    .alert,
    .jq-toast-single {
        border-radius: <?= $border_radius ?>px !important;
        overflow: hidden;
    }
    
    input,
    textarea,
    select,
    .btn,
    .btn-group,
    .dropdown-menu,
    .select2-container--open .select2-dropdown,
    .select2-container--default .select2-selection,
    .select2-container .select2-selection .select2-selection__choice,
    .tooltip-inner,
    .nav-wrapper-side.opened .nav-items .parent {
        border-radius: <?= $border_radius / 2 ?>px !important;
        overflow: hidden;
    }
    
    .table {
        border-radius: <?= $border_radius ?>px <?= $border_radius ?>px 0 0 !important;
    }
    
    .nav-wrapper-side.opened .nav-items li.active .parent {
        border-radius: <?= $border_radius / 2 ?>px <?= $border_radius / 2 ?>px 0 0 !important;
    }
    
    .pagination li:first-child > * {
        border-radius: <?= $border_radius / 2 ?>px 0 0 <?= $border_radius / 2 ?>px !important;
    }
    
    .pagination li:last-child > * {
        border-radius: 0 <?= $border_radius / 2 ?>px <?= $border_radius / 2 ?>px 0 !important;
    }
    
    .btn-group .btn,
    .nav-wrapper-side .item button {
        border-radius: 0 !important;
    }
</style>