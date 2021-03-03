<?php

namespace backend\modules\Blog\query;

use Yii;
use yii\db\Expression;
use speedrunner\db\ActiveQuery;


class BlogQuery extends ActiveQuery
{
    public function published()
    {
        return $this->andWhere(['<=', 'blog.published_at', date('Y-m-d H:i:s')]);
    }
}