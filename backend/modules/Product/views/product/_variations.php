<div class="table-responsive">
    <table class="table table-bordered m-0">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Specification') ?></th>
                <th><?= Yii::t('app', 'Option') ?></th>
                <th><?= Yii::t('app', 'Price') ?></th>
                <th><?= Yii::t('app', 'Quantity') ?></th>
                <th><?= Yii::t('app', 'SKU') ?></th>
                <th style="width: 15%;"></th>
            </tr>
        </thead>
        
        <tbody>
            <?php if ($model->variations) { ?>
                <?php foreach ($model->variations as $value) { ?>
                    <tr>
                        <td>
                            <span><?= $value->specification->name ?></span>
                        </td>
                        <td>
                            <span><?= $value->option->name ?></span>
                        </td>
                        <td>
                            <span><?= $value->price ?></span>
                        </td>
                        <td>
                            <span><?= $value->quantity ?></span>
                        </td>
                        <td>
                            <span><?= $value->sku ?></span>
                        </td>
                        <td>
                            <input type="hidden" name="Product[variations_tmp][<?= $value->id ?>][specification_id]" value="<?= $value->specification->id ?>">
                            <input type="hidden" name="Product[variations_tmp][<?= $value->id ?>][option_id]" value="<?= $value->option->id ?>">
                            <button type="button"
                                    class="btn btn-primary btn-block btn-icon"
                                    data-toggle="ajax-button"
                                    data-action="<?= Yii::$app->urlManager->createUrl(['product/variation/update', 'id' => $value->id]) ?>"
                                    data-type="modal"
                            >
                                <i class="fas fa-edit"></i>
                                <?= Yii::t('app', 'Update') ?>
                            </button>
                            <button type="button" class="btn btn-danger btn-block btn-icon btn-variations-remove">
                                <i class="fas fa-trash"></i>
                                <?= Yii::t('app', 'Delete') ?>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td>
                    <select id="variation-specification" class="form-control"></select>
                </td>
                <td>
                    <select id="variation-option" class="form-control"></select>
                </td>
                <td colspan="3"></td>
                <td>
                    <button type="button" class="btn btn-success btn-block btn-icon btn-variations-add">
                        <i class="fas fa-plus"></i>
                        <?= Yii::t('app', 'Add') ?>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var specificationId, specificationValue,
            optionId, optionValue,
            rndNumber, html;
        
        $(document).on('click', '.btn-variations-add', function() {
            specificationId = $('#variation-specification').val();
            specificationValue = $('#variation-specification option:selected').text();
            optionId = $('#variation-option').val();
            optionValue = $('#variation-option option:selected').text();
            
            rndNumber = Date.now();
            html = '<tr>';
            
            html += '<td>' + specificationValue + '</td>';
            html += '<td>' + optionValue + '</td>';
            html += '<td></td><td></td><td></td>';
            
            html += '<td><input type="hidden" name="Product[variations_tmp][' + rndNumber + '][specification_id]" value="' + specificationId + '">';
            html += '<input type="hidden" name="Product[variations_tmp][' + rndNumber + '][option_id]" value="' + optionId + '">';
            html += '<button type="button" class="btn btn-danger btn-block btn-icon btn-variations-remove">';
            html += '<i class="fas fa-trash"></i><?= Yii::t('app', 'Delete') ?></button></td></tr>';
            
            $('tbody').append(html);
        });
        
        $(document).on('click', '.btn-variations-remove', function() {
            $(this).parents('tr').remove();
        });
    });
</script>
