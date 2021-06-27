<?php

namespace backend\modules\User\search;

use Yii;
use yii\base\Model;

use backend\modules\User\models\User;


class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'role_id', 'email', 'full_name', 'phone', 'address', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = User::find()
            ->joinWith(['profile'])
            ->with(['role']);
        
        $attribute_groups = [
            '=' => ['user.id', 'user.role_id'],
            'like' => [
                'user.username', 'user.email', 'user.created_at', 'user.updated_at',
                'user_profile.full_name', 'user_profile.phone', 'user_profile.address',
            ],
        ];
        
        $dataProvider = Yii::$app->services->data->search($this, $query, $attribute_groups);
        
        foreach ($this->profile_attributes as $p_a) {
            $dataProvider->sort->attributes[$p_a] = [
                'asc' => ["user_profile.$p_a" => SORT_ASC],
                'desc' => ["user_profile.$p_a" => SORT_DESC],
            ];
        }
        
		return $dataProvider;
    }
}
