<?php

namespace backend\modules\User\modelsSearch;

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
            [['username', 'role', 'email', 'full_name', 'phone', 'address', 'created', 'updated'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
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
        
        $this->load($params);
		$this->beforeSearch();

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'User.id' => $this->id,
            'User.role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'User.username', $this->username])
            ->andFilterWhere(['like', 'User.email', $this->email])
            ->andFilterWhere(['like', 'UserProfile.full_name', $this->full_name])
            ->andFilterWhere(['like', 'UserProfile.phone', $this->phone])
            ->andFilterWhere(['like', 'UserProfile.address', $this->address])
            ->andFilterWhere(['like', 'User.created', $this->created])
            ->andFilterWhere(['like', 'User.updated', $this->updated]);
        
        foreach ($this->profile_attributes as $p_a) {
            $dataProvider->sort->attributes[$p_a] = [
                'asc' => ["UserProfile.$p_a" => SORT_ASC],
                'desc' => ["UserProfile.$p_a" => SORT_DESC],
            ];
        }
        
        $dataProvider->pagination->totalCount = $query->count();

		$this->afterSearch();
		return $dataProvider;
    }
}
