<?php

namespace backend\modules\User\search;

use Yii;
use yii\base\Model;

use backend\modules\User\models\UserRole;


class UserRoleSearch extends UserRole
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = UserRole::find();
        
        $attribute_groups = [
            '=' => ['id'],
            'like' => ['name', 'created_at', 'updated_at'],
        ];
        
        return Yii::$app->services->data->search($this, $query, $attribute_groups);
    }
}
