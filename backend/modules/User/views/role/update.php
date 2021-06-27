<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\widgets\crud\UpdateWidget;
use wbraganca\fancytree\FancytreeWidget;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update: {value}', ['value' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$routes = $model->service->createTreeFromRoutes($model->enums->routes(), $model->routes);

echo UpdateWidget::widget([
    'model' => $model,
    'tabs' => [
        'information' => [
            'label' => Yii::t('app', 'Information'),
            'attributes' => [
                'name' => 'text_input',
            ],
        ],
        
        'routes' => [
            'label' => Yii::t('app', 'Routes'),
            'attributes' => [
                FancytreeWidget::widget([
                    'id' => 'user-routes-tree',
                    'options' => [
                        'source' => $routes,
                        'checkbox' => true,
                        'selectMode' => 3,
                    ],
                ]),
            ],
        ],
    ],
]);

?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(document).on('submit', '#update-form', function() {
			$.ui.fancytree.getTree('#fancyree_user-routes-tree').generateFormElements('UserRole[routes][]', false, {
                filter: function(node) {
                    return node.isSelected() && !node.children;
                }
            });
		});
    });
</script>
