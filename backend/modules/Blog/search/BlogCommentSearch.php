<?php

namespace backend\modules\Blog\search;

use Yii;
use backend\modules\Blog\models\BlogComment;


class BlogCommentSearch extends BlogComment
{
    public function rules()
    {
        return [
            [['id', 'blog_id', 'user_id'], 'integer'],
            [['text', 'status', 'created_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlogComment::find()
            ->with(['blog', 'user']);
        
        $attribute_groups = [
            '=' => ['id', 'blog_id', 'user_id', 'status'],
            'like' => ['text', 'created_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
