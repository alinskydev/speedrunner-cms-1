<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Assign: {name}', ['name' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Block pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['id' => 'update-form'],
]); ?>

<h2 class="main-title">
    <?= $this->title ?>
    <?= Yii::$app->services->html->saveButtons(['save']) ?>
</h2>

<div class="row">
    <div class="col-lg-2 col-md-3">
        <ul class="nav flex-column nav-pills main-shadow" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab-information">
                    <?= Yii::t('app', 'Information') ?>
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
            <div id="tab-information" class="tab-pane active">
                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'slug')->textInput() ?>
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
                                        <span class="fas fa-times"></span>
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
                                            <span class="fas fa-times"></span>
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
                        <span class="fas fa-times"></span>
                    </button>
                </div>
            </div>
            
            <div id="tab-seo-meta" class="tab-pane fade">
                <?= $this->render('@backend/modules/Seo/views/meta/meta', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#sortable-from li button').tooltip({
            animated: 'fade',
            placement: 'auto',
            html: true
        });
        
        $(document).on('click', '#sortable-to .btn-danger', function() {
            $(this).closest('li').remove();
        });
        
        //        --------------------------------------------------------
        
        $('#sortable-from').sortable({
            handle: '.table-sorter',
            placeholder: 'sortable-placeholder mb-2',
            connectWith: '#sortable-to',
            helper: 'clone',
            start: function (event, ui) {
                ui.placeholder.height(ui.helper.outerHeight());
                
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
        
        $('#sortable-to').sortable({handle: '.table-sorter', placeholder: 'sortable-placeholder mb-2'}).disableSelection();
    });
</script>
