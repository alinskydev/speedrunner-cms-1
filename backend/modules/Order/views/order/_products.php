<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 1%;"></th>
            <th>№</th>
            <th><?= $product_mdl->getAttributeLabel('product_id') ?></th>
            <th><?= $product_mdl->getAttributeLabel('price') ?></th>
            <th><?= $product_mdl->getAttributeLabel('quantity') ?></th>
            <th><?= $product_mdl->getAttributeLabel('total_price') ?></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($model->products as $key => $p) { ?>
            <tr>
                <td>
                    <img src="<?= Yii::$app->sr->image->thumb(ArrayHelper::getValue($p->product_json, 'image'), [100, 100]) ?>">
                </td>
                <td><?= $key + 1 ?></td>
                <td><?= ArrayHelper::getValue($p->product_json, 'name') ?></td>
                <td><?= $p->price ?></td>
                <td><?= $p->quantity ?></td>
                <td><?= $p->total_price ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
