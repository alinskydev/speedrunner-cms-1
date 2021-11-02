<?php

namespace backend\modules\Blog\search;

use Yii;
use backend\modules\Blog\models\Blog;


class BlogSearch extends Blog
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
            [['id', 'category_id', 'tags_tmp'], 'integer'],
            [['name', 'slug', 'published_at', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = Blog::find()
            ->joinWith(['tags'])
            ->with(['category'])
            ->groupBy('id');
        
        $attribute_groups = [
            '=' => ['blog.id', 'blog.category_id', 'tags_tmp' => 'blog_tag.id'],
            'like' => ['blog.slug', 'blog.published_at', 'blog.created_at', 'blog.updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}