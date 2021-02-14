<?php

namespace backend\modules\User\query;

use Yii;
use yii\helpers\StringHelper;
use yii\db\Expression;
use speedrunner\db\ActiveQuery;


class UserQuery extends ActiveQuery
{
    public function itemsList($attr, $type, $q = null, $limit = 20)
    {
        switch ($type) {
            case 'self':
                $this->select(['User.id', "User.$attr as text"])->andFilterWhere(['like', "User.$attr", $q]);
                break;
            case 'profile':
                $this->joinWith(['profile'], false)->select(['User.id', "UserProfile.$attr as text"])->andFilterWhere(['like', "UserProfile.$attr", $q]);
                break;
            default:
                $this->andWhere('false');
        }
        
        return $this->limit($limit);
    }
}