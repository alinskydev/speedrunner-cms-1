<?php

namespace backend\modules\Block\search;

use Yii;
use yii\base\Model;

use backend\modules\Block\models\BlockPage;


class BlockPageSearch extends BlockPage
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['sluggable']);
        
        return $behaviors;
    }
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'slug', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlockPage::find();
        
        $attribute_groups = [
            'match' => ['id'],
            'like' => ['slug', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
