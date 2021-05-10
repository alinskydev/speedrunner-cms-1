<?php

namespace speedrunner\services;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use speedrunner\db\ActiveRecord;
use speedrunner\db\ActiveQuery;


class DataService
{
    public static function search(ActiveRecord $model, ActiveQuery $query, array $attribute_groups)
    {
        $query->addSelect(["{$model->tableName()}.*"]);
        
        foreach ($attribute_groups as $group_name => $attributes) {
            foreach ($attributes as $key => $a) {
                $dot_position = strpos($a, '.');
                $model_attributes[$a] = is_int($key) ? substr($a, $dot_position ? $dot_position + 1 : 0, strlen($a)) : $key;
            }
            
            switch ($group_name) {
                case 'match':
                    $attributes = array_combine($attributes, array_map(fn($value) => $model->{$model_attributes[$value]}, $attributes));
                    $query->andFilterWhere($attributes);
                    break;
                default:
                    $attributes = array_map(fn($value) => [$group_name, $value, $model->{$model_attributes[$value]}], $attributes);
                    array_unshift($attributes, 'and');
                    $query->andFilterWhere($attributes);
            }
        }
        
        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);
        
        if (!$model->validate()) {
            $query->andWhere('false');
        }
        
        //        Translations
        
        if ($translation_attributes = ArrayHelper::getValue($model->behaviors(), 'translation.attributes')) {
            $lang = Yii::$app->language;
            
            foreach ($translation_attributes as $t_a) {
                $column = $model->tableName() . ".$t_a";
                $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($column, '$.$lang'))"), strtolower($model->{$t_a})]);
                $query->addSelect([new Expression("$column->>'$.$lang' as json_$t_a")]);
                
                $dataProvider->sort->attributes[$t_a] = [
                    'asc' => ["json_$t_a" => SORT_ASC],
                    'desc' => ["json_$t_a" => SORT_DESC],
                ];
            }
        }
        
        return $dataProvider;
    }
}
