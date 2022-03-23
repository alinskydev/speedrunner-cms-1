<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use alexantr\elfinder\InputFile;
use alexantr\tinymce\TinyMCE;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\web\JsExpression;

?>

<?= Html::beginTag(
    'table',
    ArrayHelper::merge(
        ['class' => 'table table-relations'],
        $table_options
    )
) ?>

<thead>
    <tr>
        <th style="width: 50px;"></th>
        <?php

        foreach ($attributes as $key => $attribute) {
            $name = is_array($attribute) ? $attribute['name'] : $key;
            echo Html::tag('th', $relations[0]->getAttributeLabel($name));
        }

        ?>
        <th style="width: 50px;"></th>
    </tr>
</thead>

<tbody data-sr-trigger="sortable">
    <?php foreach ($relations as $relation) { ?>
        <?php $relation_id = $relation->isNewRecord ? '__key__' : $relation->id ?>

        <tr class="<?= $relation->isNewRecord ? 'table-new-relation' : null ?>" data-table="<?= Inflector::camel2id($name_prefix) ?>">
            <td>
                <div class="btn btn-primary table-sorter">
                    <i class="fas fa-arrows-alt"></i>
                </div>
            </td>

            <?php

            foreach ($attributes as $key => $attribute) {
                echo Html::beginTag('td');

                $name = is_array($attribute) ? $attribute['name'] : $key;
                $type = is_array($attribute) ? $attribute['type'] : $attribute;

                $container_options = ['template' => '{input}'];

                $options = [
                    'name' => "{$name_prefix}[$relation_id][$name]",
                    'id' => Html::getInputIdByName("{$name_prefix}[$relation_id][$name]"),
                ];

                switch ($type) {
                    case 'text_input':
                        echo $form->field(
                            $relation,
                            $name,
                            ArrayHelper::merge(
                                $container_options,
                                ArrayHelper::getValue($attribute, 'container_options', [])
                            )
                        )->textInput(
                            ArrayHelper::merge(
                                $options,
                                ArrayHelper::getValue($attribute, 'options', [])
                            )
                        );
                        break;

                    case 'text_area':
                        echo $form->field(
                            $relation,
                            $name,
                            ArrayHelper::merge(
                                $container_options,
                                ArrayHelper::getValue($attribute, 'container_options', [])
                            )
                        )->textArea(
                            ArrayHelper::merge(
                                $options,
                                ['rows' => 5],
                                ArrayHelper::getValue($attribute, 'options', [])
                            )
                        );
                        break;

                    case 'checkbox':
                        echo $form->field(
                            $relation,
                            $name,
                            ArrayHelper::merge(
                                $container_options,
                                ArrayHelper::getValue($attribute, 'container_options', [])
                            )
                        )->checkbox(
                            ArrayHelper::merge(
                                $options,
                                ['class' => 'custom-control-input'],
                                ArrayHelper::getValue($attribute, 'options', [])
                            )
                        )->label('', ['class' => 'custom-control-label']);
                        break;

                    case 'select':
                        echo $form->field(
                            $relation,
                            $name,
                            ArrayHelper::merge(
                                $container_options,
                                ArrayHelper::getValue($attribute, 'container_options', [])
                            )
                        )->dropDownList(
                            ArrayHelper::getValue($attribute, 'data', []),
                            ArrayHelper::merge(
                                $options,
                                ArrayHelper::getValue($attribute, 'options', [])
                            )
                        );
                        break;

                    case 'file_manager':
                        echo $form->field(
                            $relation,
                            $name,
                            ArrayHelper::merge(
                                [
                                    'options' => [
                                        'data-sr-trigger' => 'file_manager',
                                    ],
                                ],
                                $container_options,
                                ArrayHelper::getValue($attribute, 'container_options', [])
                            )
                        )->widget(
                            InputFile::className(),
                            ArrayHelper::merge(
                                $options,
                                ['options' => $options],
                                ArrayHelper::getValue($attribute, 'options', [])
                            )
                        );
                        break;

                    case 'function':
                        echo $attribute['value']($form, $relation);
                        break;

                    default:
                        echo $attribute;
                }

                echo Html::endTag('td');
            }

            ?>

            <td>
                <button type="button" class="btn btn-danger btn-remove">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    <?php } ?>
</tbody>

<tfoot>
    <tr>
        <td colspan="<?= count($attributes) + 2 ?>">
            <button type="button" class="btn btn-success btn-block btn-add" data-table="<?= Inflector::camel2id($name_prefix) ?>">
                <i class="fas fa-plus"></i>
            </button>
        </td>
    </tr>
</tfoot>

<?= Html::endTag('table') ?>