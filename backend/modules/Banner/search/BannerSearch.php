<?php

namespace backend\modules\Banner\search;

use Yii;
use yii\base\Model;

use backend\modules\Banner\models\Banner;


class BannerSearch extends Banner
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'location', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = Banner::find();
        
        $attribute_groups = [
            'match' => ['id', 'location'],
            'like' => ['name', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
