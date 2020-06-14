<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Assign: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Block Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'edit-form', 'enctype' => 'multipart/form-data'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Html::submitButton(
        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
        ['class' => 'btn btn-primary btn-icon float-right']
    ) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-general">
                    <?= Yii::t('app', 'General') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-assign">
                    <?= Yii::t('app', 'Assign') ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab-seo-meta">
                    <?= Yii::t('app', 'SEO meta') ?>
                </a>
            </li>
        </ul>
    </div>
    
    <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
        <div class="tab-content main-shadow p-3">
            <div id="tab-general" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'url')->textInput() ?>
            </div>
            
            <div id="tab-assign" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-6">
                        <h4><b><?= Yii::t('app', 'Types') ?></b></h4><hr>
                        <ul id="sortable-from" class="connectedSortable p-0 m-0">
                            <?php foreach ($types as $t) { ?>
                                <li class="mb-2 d-flex" data-id="<?= $t->id ?>">
                                    <div class="btn btn-light table-sorter">
                                        <i class="fas fa-arrows-alt"></i>
                                    </div>
                                    <button class="btn btn-primary btn-block"
                                            type="button"
                                            title="<img src='<?= $t['image'] ?>' width='100%'>"
                                    >
                                        <?= $t->label ?>
                                    </button>
                                    <button class="btn btn-danger btn-remove d-none" type="button">
                                        <span class="fa fa-times"></span>
                                    </button>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
                        <h4><?= Yii::t('app', 'Used') ?></h4><hr>
                        <ul id="sortable-to" class="px-0 pb-5 m-0">
                            <?php if ($model->blocks) { ?>
                                <?php foreach ($model->blocks as $b) { ?>
                                    <li class="mb-2 d-flex">
                                        <div class="btn btn-light table-sorter">
                                            <i class="fas fa-arrows-alt"></i>
                                        </div>
                                        <button class="btn btn-primary btn-block" type="button">
                                            <?= $b->type->label ?>
                                        </button>
                                        <button class="btn btn-danger btn-remove" type="button">
                                            <span class="fa fa-times"></span>
                                        </button>
                                        <input type="hidden" name="BlockPage[blocks_tmp][<?= $b->id ?>][type_id]" value="<?= $b->type_id ?>">
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                
                <div class="btn-remove-wrap d-none">
                    <button class="btn btn-danger btn-remove" type="button">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            </div>
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= Yii::$app->sr->seo->getMetaLayout($model) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    window.onload = function() {
        $('#sortable-from li button').tooltip({
            animated: 'fade',
            placement: 'auto',
            html: true
        });
        
        $(document).on('click', '#sortable-to .btn-danger', function() {
            $(this).parents('li').remove();
        });
        
//        --------------------------------------
        
        $('#sortable-from').sortable({
            handle: '.table-sorter',
            connectWith: '#sortable-to',
            helper: 'clone',
            start: function (event, ui) {
                $(ui.item).show();
                clone = $(ui.item).clone();
                before = $(ui.item).prev();
                parent = $(ui.item).parent();
            },
            stop: function (event, ui) {
                if (ui.item.parent().is('#sortable-to')) {
                    if (before.length) {
                        before.after(clone);
                    } else {
                        parent.prepend(clone);
                    }
                    
                    hiddenInput = '<input type="hidden" name="BlockPage[blocks_tmp][' + Date.now() + '][type_id]" value="' + ui.item.data('id') + '">';
                    ui.item.append(hiddenInput);
                    ui.item.find('.btn-remove').removeClass('d-none');
                }
            }
        }).disableSelection();
        
        $('#sortable-to').sortable({handle: '.table-sorter'}).disableSelection();
    };
</script>

<style>
/*
    .attr-mover {
        left: 5px;
    }
    
    #sortable-to {
        padding: 0 0 30px;
        border-bottom: 1px #e3e5e7 solid;
        min-height: 0;
    }
    
    #sortable-from .btn-danger,
    #sortable-to .btn-danger {
        position: absolute;
        top: 0;
        right: 0;
    }
*/
</style>
