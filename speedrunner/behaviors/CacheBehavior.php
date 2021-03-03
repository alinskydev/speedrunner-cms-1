<?php

namespace speedrunner\behaviors;

use Yii;
use yii\base\Behavior;
use speedrunner\db\ActiveRecord;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;


class CacheBehavior extends Behavior
{
    public array $tags;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'process',
            ActiveRecord::EVENT_AFTER_UPDATE => 'process',
            ActiveRecord::EVENT_AFTER_DELETE => 'process',
        ];
    }
    
    public function process($event)
    {
        TagDependency::invalidate(Yii::$app->cache, $this->tags);
    }
}
