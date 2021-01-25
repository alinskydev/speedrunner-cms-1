<?php

namespace backend\modules\User\models\query;

use Yii;
use yii\helpers\StringHelper;
use yii\db\Expression;
use common\framework\ActiveQuery;


class UserQuery extends ActiveQuery
{
    public function itemsList($attr, $type, $q = null, $limit = 20)
    {
        switch ($type) {
            case 'self':
                $this->select(['User.id', "User.$attr as text"])->andFilterWhere(['like', "User.$attr", $q]);
                break;
            case 'profile':
                $this->select(['User.id', "UserProfile.$attr as text"])->andFilterWhere(['like', "UserProfile.$attr", $q]);
                break;
        }
        
        return $this->joinWith(['profile'], false)->limit($limit);
    }
}