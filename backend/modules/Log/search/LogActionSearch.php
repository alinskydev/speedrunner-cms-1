<?php

namespace backend\modules\Log\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use backend\modules\Log\models\LogAction;


class LogActionSearch extends LogAction
{
    public $attrs_old;
    public $attrs_new;
    
    public function rules()
    {
        return [
            [['id', 'user_id', 'model_id'], 'integer'],
            [['type', 'model_class', 'created_at'], 'safe'],
            [['attrs_old', 'attrs_new'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = LogAction::find()
            ->joinWith(['attrs'])
            ->with(['user'])
            ->groupBy('log_action.id');
        
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
            'log_action.id' => $this->id,
            'log_action.user_id' => $this->user_id,
            'log_action.model_class' => $this->model_class,
            'log_action.model_id' => $this->model_id,
        ]);
        
        $query->andFilterWhere(['like', 'log_action.type', $this->type])
            ->andFilterWhere(['like', 'log_action.created_at', $this->created_at])
            ->andFilterWhere(['like', 'log_action_attr.name', $this->attrs_old])
            ->andFilterWhere(['like', 'log_action_attr.name', $this->attrs_new]);
        
		return $dataProvider;
    }
}