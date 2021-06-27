<?php

namespace backend\modules\Page\search;

use Yii;
use yii\base\Model;

use backend\modules\Page\models\Page;


class PageSearch extends Page
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
        $query = Page::find();
        
        $attribute_groups = [
            '=' => ['id'],
            'like' => ['slug', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}