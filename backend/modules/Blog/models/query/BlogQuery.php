<?php

namespace backend\modules\Blog\models\query;

use Yii;
use yii\db\Expression;
use common\framework\ActiveQuery;


class BlogQuery extends ActiveQuery
{
    public function published()
    {
        return $this->andWhere(['<=', 'published', date('Y-m-d H:i:s')]);
    }
}