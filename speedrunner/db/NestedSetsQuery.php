<?php

namespace speedrunner\db;

use Yii;
use yii\db\Expression;
use creocoder\nestedsets\NestedSetsQueryBehavior;


class NestedSetsQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
    
    public function withoutRoots()
    {
        return $this->andWhere(['>', "$this->table_name.depth", 0]);
    }
    
    public function itemsTree($attr, $type)
    {
        switch ($type) {
            case 'self':
                $this->addSelect(['id', new Expression("CONCAT(REPEAT(('- '), (depth - 1)), $this->table_name.name) as text")]);
                break;
            case 'translation':
                $this->addSelect(['id', new Expression("CONCAT(REPEAT(('- '), (depth - 1)), $this->table_name.name->>'$.$this->lang') as text")]);
                break;
        }
        
        return $this->orderBy('lft ASC');
    }
}