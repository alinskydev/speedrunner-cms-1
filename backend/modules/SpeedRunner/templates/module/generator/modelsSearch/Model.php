<?php

use yii\helpers\ArrayHelper;

//      DB SCHEMA

$dbSchema = Yii::$app->db->schema;
$columns = $dbSchema->getTableSchema($model->table_name)->columns;

//      RULES & SEARCH

$rules = $model->generateSearchRules($columns);
$searchConditions = $model->generateSearchConditions($columns);

$attrs = $model->attrs_fields ?: [];
$attrs_translation = array_filter($attrs, function ($value) {
    return ArrayHelper::getValue($value, 'has_translation');
});

echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
<?php if ($attrs_translation) { ?>
use yii\db\Expression;
<?php } ?>

use backend\modules\<?= $model->module_name ?>\models\<?= $model->table_name ?>;


class <?= $model->table_name ?>Search extends <?= $model->table_name . "\n" ?>
{
<?php if(isset($attrs['url'])) { ?>
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
        
<?php if ($attrs_translation) { ?>
        //        TRANSLATIONS
        
        $lang = Yii::$app->language;
        
        foreach ($this->translation_attrs as $t_a) {
            $query->andFilterWhere(['like', new Expression("JSON_EXTRACT($t_a, '$.$lang')"), $this->{$t_a}]);
            $query->addSelect(['*', new Expression("$t_a->>'$.$lang' as json_$t_a")]);
            
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ["json_$t_a" => SORT_ASC],
                'desc' => ["json_$t_a" => SORT_DESC],
            ];
        }
<?php } ?>
        
		$this->afterSearch();
		return $dataProvider;
    }
}