<?php

namespace speedrunner\db;

use Yii;
use yii\helpers\StringHelper;
use yii\db\Expression;


class ActiveQuery extends \yii\db\ActiveQuery
{
    public function bySlug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }
    
    public function itemsList($attribute, $type, $q = null, $limit = 20)
    {
        $lang = Yii::$app->language;
        
        $model_class = StringHelper::basename($this->modelClass);
        
        switch ($type) {
            case 'self':
                $this->select([
                    "$model_class.id",
                    "$model_class.$attribute as text",
                ])->andFilterWhere([
                    'like', "$model_class.$attribute", $q
                ]);
                
                break;
            case 'translation':
                $this->select([
                    "$model_class.id",
                    new Expression("$model_class.$attribute->>'$.$lang' as text"),
                ])->andFilterWhere([
                    'like', new Expression("LOWER(JSON_EXTRACT($model_class.$attribute, '$.$lang'))"), strtolower($q)
                ]);
                
                break;
            default:
                $this->andWhere('false');
        }
        
        return $this->limit($limit);
    }
}