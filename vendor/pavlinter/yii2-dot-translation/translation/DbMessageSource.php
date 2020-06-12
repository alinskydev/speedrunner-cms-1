<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs, 2015
 * @package yii2-dot-translation
 * @version 2.1.0
 */

namespace pavlinter\translation;

use Yii;
use yii\db\Query;
use yii\i18n\MissingTranslationEvent;

/**
 * @author Pavels Radajevs <pavlinter@gmail.com>
 */
class DbMessageSource extends \yii\i18n\DbMessageSource
{
    public $autoInsert = true;

    public $dotMode;

    public $cachingDuration = 3600;

    private $_messages = [];

    private $messagesId = [];
    
    public $sourceMessageTable = '{{%TranslationSource}}';
    
    public $messageTable = '{{%TranslationMessage}}';
    /**
     * Initializes the DbMessageSource component.
     */
    public function init()
    {
        parent::init();
        if ($this->autoInsert) {
            $this->on(static::EVENT_MISSING_TRANSLATION,function($event){
                if (!$this->issetId($event->category, $event->message)) {
                    $query = new Query();
                    $id = $query->select("id")->from($this->sourceMessageTable)
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
                    /* @var $i18n I18N */
                    $i18n = Yii::$app->i18n;
                    $languages = $i18n->getLanguages();
                    foreach ($languages as $language_id => $language) {
                        $query = new Query();
                        $exists = $query->from($this->messageTable)->where([
                            'id' => $id,
                            'language_id' => $language['id'],
                        ])->exists($this->db);
                        if (!$exists) {
                            $this->db->createCommand()->insert($this->messageTable,[
                                'id' => $id,
                                'language_id' => $language['id'],
                                'translation'  => '',
                            ])->execute();
                        }
                    }
                    $this->addMessageId($event->category, $event->message, $id);
                }
                $event->translatedMessage = $event->message;
            });
        }
    }

    /**
     * Loads the message translation for the specified language and category.
     * If translation for specific locale code such as `en-US` isn't found it
     * tries more generic `en`.
     *
     * @param string $category the message category
     * @param string $language the target language
     * @return array the loaded messages. The keys are original messages, and the values
     * are translated messages.
     */
    public function loadMessages($category, $language)
    {
        $I18n = Yii::$app->getI18n();
        $languages = $I18n->getLanguages();
        $newLanguage = null;

        if (is_numeric($language)) {
            if (isset($languages[$language])) {
                $newLanguage = $languages[$language]['id'];
            }
        } else if (is_string($language)) {
            if ($language !== Yii::$app->language) {
                foreach ($languages as $id => $lang) {
                    if (isset($lang[$I18n->langColCode])) {
                        $newLanguage = $lang['id'];
                        break;
                    }
                }
            } else {
                $newLanguage = null;
            }
        }

        if ($newLanguage === null) {
            $language = $I18n->getId();
        } else {
            $language = $newLanguage;
        }

        return $this->loadMessagesFromDb($category, $language);
    }

    /**
     * Loads the messages from database.
     * You may override this method to customize the message storage in the database.
     * @param string $category the message category.
     * @param string $language the target language.
     * @return array the messages loaded from database.
     */
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
            $result[$message['message']] = $message['translation'];
            $this->addMessageId($category, $message['message'], $message['id']);
        }
        
        return $result;
    }


    /**
     * Translates the specified message.
     * If the message is not found, a [[EVENT_MISSING_TRANSLATION|missingTranslation]] event will be triggered.
     * If there is an event handler, it may provide a [[MissingTranslationEvent::$translatedMessage|fallback translation]].
     * If no fallback translation is provided this method will return `false`.
     * @param string $category the category that the message belongs to.
     * @param string $message the message to be translated.
     * @param string $language the target language.
     * @return string|boolean the translated message or false if translation wasn't found.
     */
    protected function translateMessage($category, $message, $language)
    {
        $key = $language . '/' . $category;
        if (!isset($this->_messages[$key])) {
            $this->_messages[$key] = $this->loadMessages($category, $language);
        
        }

        if (array_key_exists($message, $this->_messages[$key]) && $this->_messages[$key][$message] === null) {
            return $this->_messages[$key][$message];
        } elseif (isset($this->_messages[$key][$message]) && $this->_messages[$key][$message] != '') {
            return $this->_messages[$key][$message];
        } elseif ($this->hasEventHandlers(static::EVENT_MISSING_TRANSLATION)) {
            $event = new MissingTranslationEvent([
                'category' => $category,
                'message' => $message,
                'language' => $language,
            ]);

            $this->trigger(static::EVENT_MISSING_TRANSLATION, $event);
            if ($event->translatedMessage !== null) {
                return $this->_messages[$key][$message] = $event->translatedMessage;
            }
        }

        return $this->_messages[$key][$message] = false;
    }

    /**
     * @param $category
     * @param $language
     * @return \yii\db\Command
     */
    public function getCommandQuery($category, $language)
    {
        $query = new Query();
        $query->select(['t1.id', 't1.message message', 't2.translation translation'])
            ->from([$this->sourceMessageTable . ' t1'])
            ->innerJoin($this->messageTable . ' t2','t1.id = t2.id AND t2.language_id = :language')
            ->where('t1.category = :category')
            ->params([':category' => $category, ':language' => $language]);

        return $query->createCommand($this->db);
    }

    /**
     * @param $message
     * @return bool
     */
    public function getId($category, $message)
    {
        if(isset($this->messagesId[$this->hashId($category, $message)]))
        {
            return $this->messagesId[$this->hashId($category, $message)];
        }
        return false;
    }

    /**
     * @param $message
     * @return bool
     */
    public function issetId($category, $message)
    {
        return isset($this->messagesId[$this->hashId($category, $message)]);
    }

    /**
     * @param $message
     * @return bool
     */
    public function addMessageId($category, $message, $id)
    {
        $this->messagesId[$this->hashId($category, $message)] = $id;
    }

    /**
     * @param $message
     * @return bool
     */
    public function hashId($category, $message)
    {
        return md5($category . $message);
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messagesId;
    }
}
