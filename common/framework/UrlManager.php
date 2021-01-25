<?php
/**
 * @link http://phe.me
 * @copyright Copyright (c) 2014 Pheme
 * @license MIT http://opensource.org/licenses/MIT
 */

namespace common\framework;

use Yii;
use yii\web\UrlRuleInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use backend\modules\System\models\SystemLanguage;

/**
 * @author Aris Karageorgos <aris@phe.me>
 */
class UrlManager extends \yii\web\UrlManager
{
    public static $currentLanguage;
    /**
     * @var array Supported languages
     */
    public $languages;

    /**
     * @var array Language aliases
     */
    public $aliases = [];

    /**
     * @var bool Whether to display the source app language in the URL
     */
    public $displaySourceLanguage = false;
    
    /**
     * @var bool Whether to rewrite the baseUrl in th URL
     */
    public $rewriteBaseUrl = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->languages = SystemLanguage::find()->andWhere(['is_active' => 1])->indexBy('code')->asArray()->all();
        parent::init();
    }

    /**
     * Parses the URL and sets the language accordingly
     * @param \yii\web\Request $request
     * @return array|bool
     */
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
            static::$currentLanguage = $language;
            
            \common\services\I18NService::localizedRoutes();
//            Yii::$app->services->i18n->localizedRoutes();
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
                static::$currentLanguage = $language;
            }
        }
        
        return parent::parseRequest($request);
    }

    /**
     * Adds language functionality to URL creation
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        $params = (array)$params;
        $language = ArrayHelper::remove($params, 'lang', static::$currentLanguage);
        
        return $this->baseUrl . ($language ? "/$language" : null) .
            preg_replace('~' . $this->baseUrl . '~', null, parent::createUrl($params), 1);
    }
    
    public function createFileUrl($params, $scheme = null)
    {
        $params = (array)$params;
        static::$currentLanguage = null;
        $url = $this->createUrl($params);
        static::$currentLanguage = Yii::$app->language;
        return Url::ensureScheme($url, $scheme);
    }
    
    public function createAbsoluteFileUrl($params, $scheme = null)
    {
        $params = (array)$params;
        static::$currentLanguage = null;
        $url = $this->createUrl($params);
        if (strpos($url, '://') === false) {
            $hostInfo = $this->getHostInfo();
            if (strncmp($url, '//', 2) === 0) {
                $url = substr($hostInfo, 0, strpos($hostInfo, '://')) . ':' . $url;
            } else {
                $url = $hostInfo . $url;
            }
        }
        static::$currentLanguage = Yii::$app->language;

        return Url::ensureScheme($url, $scheme);
    }
    
    public function canBeCached(UrlRuleInterface $rule)
    {
        return false;
    }
}