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
                $this->select(['user.id', "user.$attr as text"])->andFilterWhere(['like', "user.$attr", $q]);
                break;
            case 'profile':
                $this->joinWith(['profile'], false)->select(['user.id', "user_profile.$attr as text"])->andFilterWhere(['like', "user_profile.$attr", $q]);
                break;
        }
        
        return $this->limit($limit);
    }
}