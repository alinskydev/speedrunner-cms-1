<?php

namespace speedrunner\base\traits;

use Yii;


trait ModelRulesTrait
{
    public function prepareRules()
    {
        return [];
    }
    
    public function rules()
    {
        $prepared_rules = $this->prepareRules();
        
        foreach ($prepared_rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                $result[] = array_merge([$attribute], $rule);
            }
        }
        
        return $result ?? [];
    }
}
