<?php

namespace speedrunner\db;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


class ActiveQuery extends \yii\db\ActiveQuery
{
    public $table_name;
    public $lang;
    public $asObject = false;
    
    public function init()
    {
        $this->table_name = $this->modelClass::tableName();
        $this->lang = Yii::$app->language;
        
        return parent::init();
    }
    
    public function asObject($value = true)
    {
        $this->asArray = true;
        $this->asObject = $value;
        
        return $this;
    }
    
    public function populate($rows)
    {
        $result = parent::populate($rows);
        
        if ($this->modelClass == 'backend\modules\Blog\search\BlogSearch' && $this->asArray) {
            $columns = (new $this->modelClass())->getTableSchema()->columns;
            
            foreach ($result as $key => $row) {
                foreach ($row as $name => $value) {
                    if (isset($columns[$name])) {
                        $result[$key][$name] = $columns[$name]->phpTypecast($value);
                    }
                }
            }
        }
        
        if ($this->asObject) {
            $behaviors = (new $this->modelClass)->behaviors();
            
            if ($attributes = ArrayHelper::getValue($behaviors, 'translation.attributes')) {
                $result = array_map(function($value) use ($attributes) {
                    foreach ($attributes as $a) {
                        if (isset($value[$a])) {
                            $value[$a] = ArrayHelper::getValue($value[$a], $this->lang);
                        }
                    }
                    
                    return $value;
                }, $result);
            }
            
            $result = Yii::$app->helpers->array->asObjects($result);
        }
        
        return $result;
    }
    
    public function bySlug($slug)
    {
        return $this->andWhere(["$this->table_name.slug" => $slug]);
    }
    
    public function itemsList($attribute, $type, $q = null, $limit = 20)
    {
        switch ($type) {
            case 'self':
                $this->select([
                    "$this->table_name.id",
                    "$this->table_name.$attribute as text",
                ])->andFilterWhere([
                    'like', "$this->table_name.$attribute", $q
                ]);
                
                break;
            case 'translation':
                $this->select([
                    "$this->table_name.id",
                    new Expression("$this->table_name.$attribute->>'$.$this->lang' as text"),
                ])->andFilterWhere([
                    'like', new Expression("LOWER(JSON_EXTRACT($this->table_name.$attribute, '$.$this->lang'))"), strtolower($q)
                ]);
                
                break;
        }
        
        return $this->limit($limit);
    }
}