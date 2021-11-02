<?php

namespace backend\modules\System\search;

use Yii;
use backend\modules\System\models\SystemLanguage;


class SystemLanguageSearch extends SystemLanguage
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'is_main'], 'integer'],
            [['name', 'code', 'image', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = SystemLanguage::find();
        
        $attribute_groups = [
            '=' => ['id', 'is_active', 'is_main'],
            'like' => ['name', 'code', 'image', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
