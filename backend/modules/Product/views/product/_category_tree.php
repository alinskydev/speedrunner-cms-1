<?php

use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

$cats = json_decode($model->cats_tmp, JSON_UNESCAPED_UNICODE);
$data = selectCats($data, $cats);

function selectCats($data, $cats)
{
    $result = [];
    
    foreach ($data as $key => $d) {
        $d['selected'] = in_array($d['id'], $cats);
        $d['children'] = selectCats($d['children'], $cats);
        
        $result[] = $d;
    }
    
    return $result;
}

?>

<div class="row">
    <div class="col-md-6">
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= Yii::t('app', 'Tree') ?>
                </h5>
            </div>
            
            <div class="p-3">
                <?= FancytreeWidget::widget([
                    'options' => [
                        'source' => $data,
                        'checkbox' => true,
                        'generateIds' => true,
                        'idPrefix' => 'id-',
                        'extensions' => [],
                        'select' => new JsExpression('function(event, data) {
                            catsValue = JSON.parse($("#product-cats_tmp").val());
                            id = parseInt(data.node.data.id);
                            
                            if (catsValue.includes(id)) {
                                catsValue.splice(catsValue.indexOf(id), 1);
                            } else {
                                catsValue.push(id);
                            };
                            
                            $("#product-cats_tmp").val(JSON.stringify(catsValue)).change();
                        }'),
                    ],
                ]); ?>
                
                <?= $form->field($model, 'cats_tmp', ['template' => '{input}'])->hiddenInput() ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="main-shadow">
            <div class="p-3 bg-primary text-white">
                <h5 class="m-0">
                    <?= Yii::t('app', 'Attributes') ?>
                </h5>
            </div>
            
            <div class="p-3">
                <div id="attributes-inner"></div>
            </div>
        </div>
    </div>
</div>

