<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\framework;

use Yii;
use yii\base\InvalidConfigException;
use yii\caching\CacheInterface;
use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

use backend\modules\Translation\models\TranslationSource;


class DbMessageSource extends \yii\i18n\DbMessageSource
{
    private $_messages = [];
    private $messagesId = [];
    
    public function init()
    {
        parent::init();
        
        $this->db = Instance::ensure($this->db, Connection::className());
        
        if ($this->enableCaching) {
            $this->cache = Instance::ensure($this->cache, 'yii\caching\CacheInterface');
        }
        
        $this->on(static::EVENT_MISSING_TRANSLATION, function($event) {
            if (!$this->issetId($event->category, $event->message)) {
                $id = (new Query())->select("id")->from($this->sourceMessageTable)
                    ->where('category = :category AND BINARY message = :message', [
                        ':category' => $event->category,
                        ':message'  => $event->message,
                    ])
                    ->scalar($this->db);
                
                if ($id === false) {
                    $this->db->createCommand()->insert($this->sourceMessageTable, [
                        'category' => $event->category,
                        'message'  => $event->message,
                    ])->execute();
                    
                    $id = $this->db->lastInsertID;
                }
                
                $languages = Yii::$app->sr->translation->languages();
                
                foreach ($languages as $language) {
                    $exists = (new Query())->from($this->messageTable)->where([
                        'id' => $id,
                        'language' => $language['code'],
                    ])->exists($this->db);
                    
                    if (!$exists) {
                        $this->db->createCommand()->insert($this->messageTable,[
                            'id' => $id,
                            'language' => $language['code'],
                            'translation'  => '',
                        ])->execute();
                    }
                }
                
                $this->addMessageId($event->category, $event->message, $id);
            }
            
            $event->translatedMessage = $event->message;
        });
    }
    
    protected function loadMessages($category, $language)
    {
        if ($this->enableCaching) {
            $key = [
                __CLASS__,
                $category,
                $language,
            ];
            
            $messages = $this->cache->get($key);
            
            if ($messages === false) {
                $messages = $this->loadMessagesFromDb($category, $language);
                $this->cache->set($key, $messages, $this->cachingDuration);
            }
            
            return $messages;
        }
        
        return $this->loadMessagesFromDb($category, $language);
    }
    
    protected function loadMessagesFromDb($category, $language)
    {
        if ($this->enableCaching) {
            $key = [
                __CLASS__,
                $category,
                $language,
            ];
            
            $messages = $this->cache->get($key);
            
            if ($messages === false) {
                $messages = $this->getCommandQuery($category, $language)->queryAll();
                $this->cache->set($key, $messages, $this->cachingDuration);
            }
        } else {
            $messages = $this->getCommandQuery($category, $language)->queryAll();
        }
        
        $result = [];
        
        foreach ($messages as $message) {
            $result[$message['message']] = nl2br($message['translation']);
            $this->addMessageId($category, $message['message'], $message['id']);
        }
        
        return $result;
    }
    
    protected function createFallbackQuery($category, $language, $fallbackLanguage)
    {
        return (new Query())->select(['message' => 't1.message', 'translation' => 't2.translation'])
            ->from(['t1' => $this->sourceMessageTable, 't2' => $this->messageTable])
            ->where([
                't1.id' => new Expression('[[t2.id]]'),
                't1.category' => $category,
                't2.language' => $fallbackLanguage,
            ])->andWhere([
                'NOT IN', 't2.id', (new Query())->select('[[id]]')->from($this->messageTable)->where(['language' => $language]),
            ]);
    }
    
    public function getCommandQuery($category, $language)
    {
        $query = new Query();
        $query->select(['t1.id', 't1.message message', 't2.translation translation'])
            ->from([$this->sourceMessageTable . ' t1'])
            ->innerJoin($this->messageTable . ' t2','t1.id = t2.id AND t2.language = :language')
            ->where('t1.category = :category')
            ->params([':category' => $category, ':language' => $language]);
        
        return $query->createCommand($this->db);
    }
    
    public function getId($category, $message)
    {
        if (isset($this->messagesId[$this->hashId($category, $message)])) {
            return $this->messagesId[$this->hashId($category, $message)];
        }
        
        return false;
    }
    
    public function issetId($category, $message)
    {
        return isset($this->messagesId[$this->hashId($category, $message)]);
    }
    
    public function addMessageId($category, $message, $id)
    {
        $this->messagesId[$this->hashId($category, $message)] = $id;
    }
    
    public function hashId($category, $message)
    {
        return md5($category . $message);
    }
    
    public function getMessages()
    {
        return $this->messagesId;
    }
}
