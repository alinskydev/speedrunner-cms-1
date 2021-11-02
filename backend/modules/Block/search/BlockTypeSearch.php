<?php

namespace backend\modules\Block\search;

use Yii;
use backend\modules\Block\models\BlockType;


class BlockTypeSearch extends BlockType
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'label', 'input_type', 'has_translation'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlockType::find();
        
        $attribute_groups = [
            '=' => ['id'],
            'like' => ['name', 'label', 'input_type', 'has_translation'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
