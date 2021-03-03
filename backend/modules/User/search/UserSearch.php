<?php

namespace backend\modules\User\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\User\models\User;


class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'role', 'email', 'full_name', 'phone', 'address', 'created_at', 'updated_at'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = User::find()
            ->joinWith(['profile']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 30,
                'pageSizeLimit' => [1, 30],
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ],
        ]);
        
        if (!$this->validate()) {
            $query->andWhere('false');
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.role' => $this->role,
        ]);
        
        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user_profile.full_name', $this->full_name])
            ->andFilterWhere(['like', 'user_profile.phone', $this->phone])
            ->andFilterWhere(['like', 'user_profile.address', $this->address])
            ->andFilterWhere(['like', 'user.created_at', $this->created_at])
            ->andFilterWhere(['like', 'user.updated_at', $this->updated_at]);
        
        foreach ($this->profile_attributes as $p_a) {
            $dataProvider->sort->attributes[$p_a] = [
                'asc' => ["user_profile.$p_a" => SORT_ASC],
                'desc' => ["user_profile.$p_a" => SORT_DESC],
            ];
        }
        
		return $dataProvider;
    }
}
