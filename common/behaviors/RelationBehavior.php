<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class RelationBehavior extends Behavior
{
    public $type;
    public $attributes;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
        ];
    }
    
    public function afterSave($event)
    {
        return $this->{$this->type}();
    }
    
    public function oneMany()
    {
        foreach ($this->attributes as $a) {
            $relations = ArrayHelper::index($this->owner->{$a['relation']}, 'id');
            $attribute = $this->owner->{$a['attribute']};
            
            if ($attribute) {
                $counter = 0;
                
                foreach ($attribute as $key => $value) {
                    $relation_mdl = ArrayHelper::getValue($relations, $key, clone($a['model']));
                    $relation_mdl->{$a['properties']['main']} = $this->owner->id;
                    
                    foreach ($a['properties']['relational'] as $p) {
                        $relation_mdl->{$p} = ArrayHelper::getValue($value, $p);
                    }
                    
                    $relation_mdl->sort = $counter;
                    $relation_mdl->save();
                    
                    ArrayHelper::remove($relations, $key);
                    $counter++;
                }
            }
            
            foreach ($relations as $value) { $value->delete(); };
        }
    }
    
    public function manyMany()
    {
        foreach ($this->attributes as $a) {
            $relations = ArrayHelper::map($this->owner->{$a['relation']}, 'id', 'id');
            $attribute = $this->owner->{$a['attribute']};
            
            if ($attribute) {
                foreach ($attribute as $value) {
                    if (!in_array($value, $relations)) {
                        $relation_mdl = clone($a['model']);
                        $relation_mdl->{$a['properties']['main']} = $this->owner->id;
                        $relation_mdl->{$a['properties']['relational']} = $value;
                        $relation_mdl->save();
                    }
                    
                    ArrayHelper::remove($relations, $value);
                }
            }
            
            $a['model']->deleteAll([$a['properties']['main'] => $this->owner->id, $a['properties']['relational'] => $relations]);
        }
    }
}
