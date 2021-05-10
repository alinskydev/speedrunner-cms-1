<?php

namespace backend\modules\Blog\search;

use Yii;
use yii\base\Model;

use backend\modules\Blog\models\BlogTag;


class BlogTagSearch extends BlogTag
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'created_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlogTag::find();
        
        $attribute_groups = [
            'match' => ['id'],
            'like' => ['name', 'created_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
