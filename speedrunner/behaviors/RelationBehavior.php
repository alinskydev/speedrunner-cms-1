<?php

namespace speedrunner\behaviors;

use Yii;
use yii\base\Behavior;
use speedrunner\db\ActiveRecord;
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
    
    public function oneOne()
    {
        foreach ($this->attributes as $a) {
            $relation_model = $this->owner->{$a['relation']} ? clone($this->owner->{$a['relation']}) : $a['model'];
            $relation_model->{$a['attributes']['main']} = $this->owner->id;
            
            foreach ($a['attributes']['relational'] as $a_r) {
                if ($this->owner->isAttributeActive($a_r)) {
                    $relation_model->{$a_r} = $this->owner->{$a_r};
                }
            }
            
            $relation_model->save();
        }
    }
    
    public function oneMany()
    {
        foreach ($this->attributes as $a_key => $a) {
            if (!$this->owner->isAttributeActive($a_key)) {
                continue;
            }
            
            $relations = ArrayHelper::index($this->owner->{$a['relation']}, 'id');
            $attribute = $this->owner->{$a_key};
            
            if ($attribute) {
                $counter = 0;
                
                foreach ($attribute as $key => $value) {
                    $relation_model = clone(ArrayHelper::getValue($relations, $key, $a['model']));
                    $relation_model->{$a['attributes']['main']} = $this->owner->id;
                    
                    foreach ($a['attributes']['relational'] as $p) {
                        isset($value[$p]) ? $relation_model->{$p} = $value[$p] : null;
                    }
                    
                    $relation_model->sort = $counter;
                    $relation_model->save();
                    
                    ArrayHelper::remove($relations, $key);
                    $counter++;
                }
            }
            
            foreach ($relations as $value) { $value->delete(); };
        }
    }
    
    public function manyMany()
    {
        foreach ($this->attributes as $a_key => $a) {
            if (!$this->owner->isAttributeActive($a_key)) {
                continue;
            }
            
            $relations = ArrayHelper::map($this->owner->{$a['relation']}, 'id', 'id');
            $attribute = $this->owner->{$a_key};
            
            if ($attribute) {
                foreach ($attribute as $value) {
                    if (!in_array($value, $relations)) {
                        $relation_model = clone($a['model']);
                        $relation_model->{$a['attributes']['main']} = $this->owner->id;
                        $relation_model->{$a['attributes']['relational']} = $value;
                        $relation_model->save();
                    }
                    
                    ArrayHelper::remove($relations, $value);
                }
            }
            
            $a['model']->deleteAll([$a['attributes']['main'] => $this->owner->id, $a['attributes']['relational'] => $relations]);
        }
    }
}
