<?php

namespace backend\modules\Product\modelsSearch;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\Product\models\ProductComment;


class ProductCommentSearch extends ProductComment
{
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id'], 'integer'],
            [['text', 'status', 'created'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProductComment::find()->alias('self')
            ->with(['product.translation', 'user']);

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
            'self.product_id' => $this->product_id,
            'self.user_id' => $this->user_id,
            'self.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'self.text', $this->text])
            ->andFilterWhere(['like', 'self.created', $this->created]);

		$this->afterSearch();
		return $dataProvider;
    }
}
