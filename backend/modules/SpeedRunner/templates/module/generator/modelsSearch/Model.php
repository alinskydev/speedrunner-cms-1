<?php

use yii\helpers\ArrayHelper;

//      DB SCHEMA

$dbSchema = Yii::$app->db->schema;
$columns = $dbSchema->getTableSchema($model->table_name)->columns;

//      RULES & SEARCH

$rules = $model->generateSearchRules($columns);
$searchConditions = $model->generateSearchConditions($columns);

echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\<?= $model->module_name ?>\models\<?= $model->table_name ?>;


class <?= $model->table_name ?>Search extends <?= $model->table_name . "\n" ?>
{
<?php if(isset($columns['url'])) { ?>
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
    
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    public function search($params)
    {
        $query = <?= $model->table_name ?>::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        
        $this->load($params);
		$this->beforeSearch();
        
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        <?= implode("\n        ", $searchConditions) ?>
        
		$this->afterSearch();
		return $dataProvider;
    }
}