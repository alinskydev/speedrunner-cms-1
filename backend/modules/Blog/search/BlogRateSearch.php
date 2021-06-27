<?php

namespace backend\modules\Blog\search;

use Yii;
use yii\base\Model;

use backend\modules\Blog\models\BlogRate;


class BlogRateSearch extends BlogRate
{
    public $item_name;
    
    public function rules()
    {
        return [
            [['id', 'blog_id', 'user_id', 'mark'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = BlogRate::find()
            ->with(['blog', 'user']);
        
        $attribute_groups = [
            '=' => ['id', 'blog_id', 'user_id', 'mark'],
            'like' => ['created_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
