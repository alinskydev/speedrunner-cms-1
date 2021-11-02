<?php

namespace backend\modules\Blog\search;

use Yii;
use backend\modules\Blog\models\BlogCategory;


class BlogCategorySearch extends BlogCategory
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
        $query = BlogCategory::find();
        
        $attribute_groups = [
            '=' => ['id'],
            'like' => ['slug', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
