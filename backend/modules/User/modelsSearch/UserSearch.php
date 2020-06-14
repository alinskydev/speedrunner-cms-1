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
        $query = User::find()->alias('self')->joinWith([
            'profile as profile',
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30
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
            'self.id' => $this->id,
            'self.role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'self.username', $this->username])
            ->andFilterWhere(['like', 'self.email', $this->email])
            ->andFilterWhere(['like', 'profile.full_name', $this->full_name])
            ->andFilterWhere(['like', 'profile.phone', $this->phone])
            ->andFilterWhere(['like', 'profile.address', $this->address])
            ->andFilterWhere(['like', 'self.created', $this->created])
            ->andFilterWhere(['like', 'self.updated', $this->updated]);
        
        foreach ($this->profile_attrs as $p_a) {
            $dataProvider->sort->attributes[$p_a] = [
                'asc' => ['profile.'.$p_a => SORT_ASC],
                'desc' => ['profile.'.$p_a => SORT_DESC],
            ];
        }

		$this->afterSearch();
		return $dataProvider;
    }
}
