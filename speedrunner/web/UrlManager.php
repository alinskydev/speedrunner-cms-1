<?php

namespace speedrunner\web;

use Yii;
use yii\web\UrlRuleInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\caching\TagDependency;

use backend\modules\System\models\SystemLanguage;


class UrlManager extends \yii\web\UrlManager
{
    public static $currentLanguage;
    public $languages;
    public $aliases = [];
    public $displaySourceLanguage = false;
    public $rewriteBaseUrl = true;
    
    public function init()
    {
        $this->languages = Yii::$app->db->cache(function($db) {
            return SystemLanguage::find()->andWhere(['is_active' => 1])->indexBy('code')->asArray()->all();
        }, 0, new TagDependency(['tags' => 'active_system_languages']));
        
        parent::init();
    }
    
    public function parseRequest($request)
    {
        if ($this->enablePrettyUrl) {
            $pathInfo = $request->getPathInfo();
            $language = explode('/', $pathInfo)[0];
            
            if (array_key_exists($language, $this->languages)) {
                $request->setPathInfo(substr_replace($pathInfo, '', 0, (strlen($language) + 1)));
            } else {
                $language = ArrayHelper::map($this->languages, 'is_main', 'code')[1];
            }
            
            $locale = ArrayHelper::getValue($this->aliases, $language, $language);
            Yii::$app->language = $locale;
            self::$currentLanguage = $language;
            
            \speedrunner\services\I18NService::setLocalizedRoutes();
        } else {
            $params = $request->getQueryParams();
            $route = isset($params[$this->routeParam]) ? $params[$this->routeParam] : '';
            if (is_array($route)) {
                $route = '';
            }
            $language = explode('/', $route)[0];
            $locale = ArrayHelper::getValue($this->aliases, $language, $language);
            if (array_key_exists($language, $this->languages)) {
                $route = substr_replace($route, '', 0, (strlen($language) + 1));
                $params[$this->routeParam] = $route;
                $request->setQueryParams($params);
                Yii::$app->language = $locale;
                self::$currentLanguage = $language;
            }
        }
        
        return parent::parseRequest($request);
    }
    
    public function createUrl($params)
    {
        $params = (array)$params;
        $language = ArrayHelper::remove($params, 'lang', self::$currentLanguage);
        
        $url = $this->baseUrl . ($language ? "/$language" : null);
        $url .= preg_replace('~' . $this->baseUrl . '~', null, parent::createUrl($params), 1);
        
        return $url;
    }
    
    public function createFileUrl($params, $scheme = null)
    {
        $params = (array)$params;
        self::$currentLanguage = null;
        $url = $this->createUrl($params);
        self::$currentLanguage = Yii::$app->language;
        return Url::ensureScheme($url, $scheme);
    }
    
    public function createAbsoluteFileUrl($params, $scheme = null)
    {
        $params = (array)$params;
        self::$currentLanguage = null;
        $url = $this->createUrl($params);
        if (strpos($url, '://') === false) {
            $hostInfo = $this->getHostInfo();
            if (strncmp($url, '//', 2) === 0) {
                $url = substr($hostInfo, 0, strpos($hostInfo, '://')) . ':' . $url;
            } else {
                $url = $hostInfo . $url;
            }
        }
        
        self::$currentLanguage = Yii::$app->language;
        return Url::ensureScheme($url, $scheme);
    }
    
    public function getRoute($params)
    {
        $params = (array)$params;
        $language = ArrayHelper::remove($params, 'lang', self::$currentLanguage);
        $url = preg_replace("-$this->baseUrl/$language/-", null, Url::to([$params[0]]), 1);
        
        return $url;
    }
    
    public function canBeCached(UrlRuleInterface $rule)
    {
        return false;
    }
}