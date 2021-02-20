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
use yii\data\ActiveDataProvider;
<?php if ($model->attrs_translation) { ?>
use yii\db\Expression;
<?php } ?>

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
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [1, 30],
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        
        if (!$this->validate()) {
            $query->andWhere('false');
            return $dataProvider;
        }
        
        <?= implode("\n        ", $searchConditions) ?>
        
<?php if ($model->attrs_translation) { ?>
        //        Translations
        
        $lang = Yii::$app->language;
        
        foreach ($this->behaviors['translation']->attributes as $t_a) {
            $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($t_a, '$.$lang'))"), strtolower($this->{$t_a})]);
            $query->addSelect(['*', new Expression("$t_a->>'$.$lang' as json_$t_a")]);
            
            $dataProvider->sort->attributes[$t_a] = [
                'asc' => ["json_$t_a" => SORT_ASC],
                'desc' => ["json_$t_a" => SORT_DESC],
            ];
        }
        
<?php } ?>
		return $dataProvider;
    }
}