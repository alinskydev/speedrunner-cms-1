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
            [['type', 'model_class', 'created'], 'safe'],
            [['attrs_old', 'attrs_new'], 'safe'],
        ];
    }
    
    public function search()
    {
        $query = LogAction::find()
            ->joinWith(['attrs'])
            ->with(['user'])
            ->groupBy('LogAction.id');
        
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
            'LogAction.id' => $this->id,
            'LogAction.user_id' => $this->user_id,
            'LogAction.model_class' => $this->model_class,
            'LogAction.model_id' => $this->model_id,
        ]);
        
        $query->andFilterWhere(['like', 'LogAction.type', $this->type])
            ->andFilterWhere(['like', 'LogAction.created', $this->created])
            ->andFilterWhere(['like', 'LogActionAttr.name', $this->attrs_old])
            ->andFilterWhere(['like', 'LogActionAttr.name', $this->attrs_new]);
        
		return $dataProvider;
    }
}