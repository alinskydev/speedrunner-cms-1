<?php

use yii\helpers\ArrayHelper;

//      DB schema

$dbSchema = Yii::$app->db->schema;
$columns = $dbSchema->getTableSchema($model->table_name)->columns;

//      Rules & search

$rules = $model->generateSearchRules($columns);
$searchConditions = $model->generateSearchConditions($columns);

$attrs = $model->attrs_fields ?: [];

echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\search;

use Yii;
use yii\base\Model;

use backend\modules\<?= $model->module_name ?>\models\<?= $model->model_name ?>;


class <?= $model->model_name ?>Search extends <?= $model->model_name . "\n" ?>
{
<?php if(isset($attrs['slug'])) { ?>
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['sluggable']);
        
        return $behaviors;
    }
    
<?php } ?>
    public function rules()
    {
        return [
            <?= implode(",\n            ", $rules) ?>,
        ];
    }
    
    public function search()
    {
        $query = <?= $model->model_name ?>::find();
        
        <?= implode("\n        ", $searchConditions) ?>
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}