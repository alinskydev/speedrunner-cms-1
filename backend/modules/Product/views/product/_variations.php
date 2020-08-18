<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for="vars-attr-choose">
                <?= Yii::t('app', 'Choose attribute') ?>
            </label>
            <select id="vars-attr-list" class="form-control"></select>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="vars-option-choose">
                <?= Yii::t('app', 'Choose option') ?>
            </label>
            <select id="vars-option-list" class="form-control"></select>
        </div>
    </div>
    <div class="col-md-2">
        <label>&nbsp;</label><br>
        <button type="button" class="btn btn-success btn-block btn-icon btn-vars-add">
            <i class="fas fa-plus"></i>
            <?= Yii::t('app', 'Add') ?>
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th><?= Yii::t('app', 'Attribute') ?></th>
                <th><?= Yii::t('app', 'Option') ?></th>
                <th><?= Yii::t('app', 'Price') ?></th>
                <th><?= Yii::t('app', 'Sku') ?></th>
                <th style="width: 15%;"></th>
            </tr>
            
            <?php if ($model->vars) { ?>
                <?php foreach ($model->vars as $var) { ?>
                    <tr>
                        <td>
                            <span><?= $var->attr->name ?></span>
                        </td>
                        <td>
                            <span><?= $var->option->name ?></span>
                        </td>
                        <td>
                            <span><?= $var->price ?></span>
                        </td>
                        <td>
                            <span><?= $var->sku ?></span>
                        </td>
                        <td>
                            <input type="hidden" name="Product[vars_tmp][<?= $var->id ?>][attribute_id]" value="<?= $var->attr->id ?>">
                            <input type="hidden" name="Product[vars_tmp][<?= $var->id ?>][option_id]" value="<?= $var->option->id ?>">
                            <button type="button"
                                    class="btn btn-primary btn-block btn-icon"
                                    data-toggle="ajax-button"
                                    data-action="<?= Yii::$app->urlManager->createUrl(['product/variation/update', 'id' => $var->id]) ?>"
                                    data-type="modal"
                            >
                                <i class="fas fa-edit"></i>
                                <?= Yii::t('app', 'Update') ?>
                            </button>
                            <button type="button" class="btn btn-danger btn-block btn-icon btn-vars-remove">
                                <i class="fas fa-trash"></i>
                                <?= Yii::t('app', 'Delete') ?>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script>
    function processVars() {
        var attributeId, attributeValue,
            optionId, optionValue,
            rndNumber, html;
        
        $(document).on('click', '.btn-vars-add', function() {
            attributeId = $('#vars-attr-list').val();
            optionId = $('#vars-option-list').val();
            attributeValue = $('#vars-attr-list option:selected').text();
            optionValue = $('#vars-option-list option:selected').text();
            
            rndNumber = Math.random();
            html = '<tr>';
            
            html += '<td>' + attributeValue + '</td>';
            html += '<td>' + optionValue + '</td>';
            html += '<td></td><td></td>';
            
            html += '<td><input type="hidden" name="Product[vars_tmp][' + rndNumber + '][attribute_id]" value="' + attributeId + '">';
            html += '<input type="hidden" name="Product[vars_tmp][' + rndNumber + '][option_id]" value="' + optionId + '">';
            html += '<button type="button" class="btn btn-danger btn-block btn-icon btn-vars-remove">';
            html += '<i class="fas fa-trash"></i><?= Yii::t('app', 'Delete') ?></button></td></tr>';
            
            $('tbody').append(html);
        });
        
        $(document).on('click', '.btn-vars-remove', function() {
            $(this).parents('tr').remove();
        });
    };
</script>
