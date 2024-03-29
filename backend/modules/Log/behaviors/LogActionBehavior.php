<?php

namespace backend\modules\Log\behaviors;

use Yii;
use yii\base\Behavior;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

use backend\modules\Log\models\LogAction;
use backend\modules\Log\models\LogActionAttr;
use backend\modules\Log\lists\LogActionModelsList;


class LogActionBehavior extends Behavior
{
    public $exclude_attributes = [];
    public $relations_one_one = [];
    public $relations_one_many = [];
    public $relations_many_many = [];
    
    private $extraAttributes = [];
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }
    
    public function afterSave($event)
    {
        $changedAttributes = $event->changedAttributes;
        
        foreach ($this->relations_one_one as $r_key => $r) {
            $relation_model = $this->owner->{$r_key};
            
            foreach ($r['attributes'] as $a) {
                $changedAttributes[$a] = ArrayHelper::getValue($relation_model, $a);
            }
        }
        
        foreach ($this->relations_one_many as $r_key => $r) {
            $owner = clone($this->owner);
            $this->extraAttributes[$r_key] = ['old' => [], 'new' => []];
            
            foreach ($owner->{$r['relation']} as $key => $relation_model) {
                foreach ($r['attributes'] as $a) {
                    $this->extraAttributes[$r_key]['old'][$key][$relation_model->getAttributeLabel($a)] = $relation_model->{$a};
                }
            }
            
            $owner->refresh();
            
            foreach ($owner->{$r['relation']} as $key => $relation_model) {
                foreach ($r['attributes'] as $a) {
                    $this->extraAttributes[$r_key]['new'][$key][$relation_model->getAttributeLabel($a)] = $relation_model->{$a};
                }
            }
        }
        
        foreach ($this->relations_many_many as $r_key => $r) {
            $owner = clone($this->owner);
            $this->extraAttributes[$r_key]['old'] = ArrayHelper::getColumn($owner->{$r['relation']}, $r['attribute']);
            $owner->refresh();
            $this->extraAttributes[$r_key]['new'] = ArrayHelper::getColumn($owner->{$r['relation']}, $r['attribute']);
        }
        
        $type = $event->name == 'afterInsert' ? 'created' : 'updated';
        $this->save($this->owner, $type, $changedAttributes, $this->extraAttributes);
    }
    
    public function beforeDelete($event)
    {
        $attributes = $this->owner->oldAttributes;
        
        foreach ($this->relations_one_one as $r_key => $r) {
            $relation_model = $this->owner->{$r_key};
            
            foreach ($r['attributes'] as $a) {
                $attributes[$a] = ArrayHelper::getValue($relation_model, $a);
            }
        }
        
        foreach ($this->relations_one_many as $r_key => $r) {
            foreach ($this->owner->{$r['relation']} as $key => $relation_model) {
                foreach ($r['attributes'] as $a) {
                    $this->extraAttributes[$r_key]['old'][$key][$relation_model->getAttributeLabel($a)] = $relation_model->{$a};
                }
                
                $this->extraAttributes[$r_key]['new'] = [];
            }
        }
        
        foreach ($this->relations_many_many as $r_key => $r) {
            $this->extraAttributes[$r_key]['old'] = ArrayHelper::getColumn($this->owner->{$r['relation']}, $r['attribute']);
            $this->extraAttributes[$r_key]['new'] = [];
        }
        
        $this->save($this->owner, 'deleted', $attributes, $this->extraAttributes);
    }
    
    private function save($model, $type, $changedAttributes, $extraAttributes)
    {
        $log_action = new LogAction();
        $log_action->user_id = Yii::$app->user->id;
        $log_action->type = $type;
        $log_action->model_class = StringHelper::basename($model->className());
        $log_action->model_id = $model->id;
        
        $transaction = Yii::$app->db->beginTransaction();
        
        if (!$log_action->save()) {
            return Yii::$app->session->addFlash('warning', Yii::t('app', "Record hasn't been saved to the actions log"));
        }
        
        $relations = ArrayHelper::getValue((new LogActionModelsList())::$data, "$log_action->model_class.relations", []);
        $counter = 0;
        
        foreach ($changedAttributes as $key => $a) {
            if (in_array($key, $this->exclude_attributes)) { continue; };
            
            if (isset($relations[$key])) {
                $relation_link = $relations[$key]['link'];
                $relation_attr = $relations[$key]['attr'];
                
                $value_new = ArrayHelper::getValue($model, "$relation_link.$relation_attr");
                $model->{$key} = $a;
                $value_old = ArrayHelper::getValue($model, "$relation_link.$relation_attr");
            } else {
                $value_old = $a;
                $value_new = $model->{$key};
            }
            
            $attr = new LogActionAttr();
            $attr->action_id = $log_action->id;
            $attr->name = $key;
            $attr->value_old = $value_old;
            $attr->value_new = $type != 'deleted' ? $value_new : null;
            $counter += $attr->value_old != $attr->value_new ? $attr->save() : 0;
        }
        
        foreach ($extraAttributes as $key => $a) {
            $attr = new LogActionAttr();
            $attr->action_id = $log_action->id;
            $attr->name = $key;
            $attr->value_old = $a['old'];
            $attr->value_new = $a['new'];
            $counter += $attr->value_old != $attr->value_new ? $attr->save() : 0;
        }
        
        $counter ? $transaction->commit() : $transaction->rollBack();
    }
}
