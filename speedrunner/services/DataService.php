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
    public static function search(ActiveRecord $model, ActiveQuery $query, array $attribute_groups, $default_sort = null)
    {
        $default_sort = $default_sort ?? ['defaultOrder' => ['id' => SORT_DESC]];
        
        $query->addSelect(["{$model->tableName()}.*"]);
        
        foreach ($attribute_groups as $group_name => $attributes) {
            $attributes = array_map(function($value, $key) use ($model, $group_name) {
                $dot_position = strpos($value, '.');
                $model_attributes[$value] = is_int($key) ? substr($value, $dot_position ? $dot_position + 1 : 0, strlen($value)) : $key;
                
                return [$group_name, $value, strtolower($model->{$model_attributes[$value]})];
            }, $attributes, array_keys($attributes));
            
            array_unshift($attributes, 'and');
            $query->andFilterWhere($attributes);
        }
        
        if (!$model->validate()) {
            $query->andWhere('false');
        }
        
        $dataProvider = Yii::createObject([
            'class' => ActiveDataProvider::className(),
            'query' => $query,
            'sort' => $default_sort,
        ]);
        
        //        Translations
        
        if ($translation_attributes = ArrayHelper::getValue($model->behaviors(), 'translation.attributes')) {
            $lang = Yii::$app->language;
            
            foreach ($translation_attributes as $t_a) {
                $column = $model->tableName() . ".$t_a";
                $query->andFilterWhere(['like', new Expression("LOWER(JSON_EXTRACT($column, '$.$lang'))"), strtolower($model->{$t_a})]);
                $query->addSelect([new Expression("$column->>'$.$lang' as json_$t_a")]);
                
                if ($dataProvider->sort) {
                    $dataProvider->sort->attributes[$t_a] = [
                        'asc' => ["json_$t_a" => SORT_ASC],
                        'desc' => ["json_$t_a" => SORT_DESC],
                    ];
                }
            }
        }
        
        return $dataProvider;
    }
}
