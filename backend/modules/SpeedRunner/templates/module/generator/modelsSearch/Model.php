<?php

use yii\helpers\ArrayHelper;

//      DB SCHEMA

$dbSchema = Yii::$app->db->schema;
$columns = $dbSchema->getTableSchema($model->table_name)->columns;

//      TRANSLATION

if ($model->with_translation) {
    $translation_attrs = ['id', 'item_id', 'lang'];
    
    $columns_translation = $dbSchema->getTableSchema($model->table_name . 'Translation')->columns;
    
    foreach ($translation_attrs as $t_a) {
        unset($columns_translation[$t_a]);
    }
    
    $columns = ArrayHelper::merge($columns_translation, $columns);
    $columns_translation = ArrayHelper::map($columns_translation, 'type', 'name');
} else {
    $columns_translation = [];
}

//      RULES & SEARCH

$rules = $model->generateSearchRules($columns);
$searchConditions = $model->generateSearchConditions($columns, $columns_translation);

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
<?php if ($model->with_translation) { ?>
        $query = <?= $model->table_name ?>::find()->alias('self')
            ->joinWith(['translation as translation']);
<?php } else { ?>
        $query = <?= $model->table_name ?>::find()->alias('self');
<?php } ?>
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        
<?php if ($model->with_translation) { ?>
        foreach ($this->translation_attrs as $t_a) {
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ['translation.' . $t_a => SORT_ASC],
                'desc' => ['translation.' . $t_a => SORT_DESC],
            ];
        }
<?php } ?>
        
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