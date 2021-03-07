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
        $apps_cache_path = [
            'api' => Yii::getAlias('@api/runtime/cache'),
            'backend' => Yii::getAlias('@backend/runtime/cache'),
            'frontend' => Yii::getAlias('@frontend/runtime/cache'),
        ];
        
        foreach ($apps_cache_path as $key => $path) {
            Yii::$app->cache->cachePath = $path;
            TagDependency::invalidate(Yii::$app->cache, $this->tags);
        }
    }
}
