<?php

/**
 * @copyright Copyright &copy; Pavels Radajevs, 2015
 * @package yii2-dot-translation
 * @version 2.1.0
 */

namespace pavlinter\translation;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use yii\caching\DbDependency;
use yii\i18n\MessageSource;

use backend\modules\System\models\SystemLanguage;

/**
 * @author Pavels Radajevs <pavlinter@gmail.com>
 */
class I18N extends \yii\i18n\I18N
{
    const DIALOG_BS = 'bs';
    const DIALOG_JQ = 'jq';
    const DIALOG_MAGNIFIC = 'mp';

    public $dotClass            = 'dot-translation';
    public $dotSymbol           = '&bull;';

    public $langTable           = 'SystemLanguage';
    public $langColCode         = 'code'; //language code ru,en ...
    public $langColLabel        = 'name';
    public $langColUpdatedAt    = 'updated_at';
    public $langColImage        = 'image';

    public $langWhere           = ['active' => 1];
    public $langOrder           = 'weight';

    public $enableCaching       = true;
    public $durationCaching     = 0;

    public $nl2br               = true;

    public $router              = '/site/dot-translation';
    public $categoryUrl         = false;
    public $categoryText        = '';
    public $langParam           = 'lang'; // $_GET KEY
    public $access              = 'dots-control';
    public $htmlScope           = false;
    public $htmlScopeClass      = 'bs';
    public $dialog              = I18N::DIALOG_MAGNIFIC; // bs or jq or mp

    private $dotMode            = null;
    private $language           = null;
    private $languageId         = null;
    private $languages          = []; //list languages
    private $dot                = null;
    private $showDot            = false;
    /**
     * @var boolean encode new message.
     */
    public $htmlEncode = false;
    /**
     * Initializes the component by configuring the default message categories.
     */
    public function init()
    {
        if (Yii::$app->request->getIsConsoleRequest()) {
            return true;
        }
        $this->initLanguage();

        if (!isset($this->translations['yii']) && !isset($this->translations['yii*'])) {
            $this->translations['yii'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@yii/messages',
            ];
        }
        if (!isset($this->translations['app']) && !isset($this->translations['app*'])) {
            $this->translations['app'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }
        if (!isset($this->translations['i18n-dot']) && !isset($this->translations['i18n-dot*'])) {
            $this->translations['i18n-dot'] = [
                'class' => 'pavlinter\translation\DbMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
            ];
        }

        if ($this->access() && !$this->isPjax()) {
            $view = Yii::$app->getView();
            $this->register($view);
        }
    }

    /**
     * @param $view
     */
    public function register($view)
    {
        $view->on($view::EVENT_END_BODY, function ($event) {

            $this->registerAssets($event->sender);
            if ($this->htmlScope) {
                echo Html::beginTag('span',['class' => $this->htmlScopeClass]);
            }

            if ($this->dialog == I18N::DIALOG_BS) {
                \yii\bootstrap\Modal::begin([
                    'header' => '<div id="dots-modal-header"><div id="dots-modal-cat-header"></div><div id="dots-modal-key-header"></div></div>',
                    'closeButton' => [
                        'class' => 'close dot-close',
                    ],
                    'options' => [
                        'id' => 'dots-btn-modal',
                    ],
                    'size' => 'modal-lg',
                    'toggleButton' => [
                        'id' => 'dots-btns',
                        'style' => 'display: none;',
                    ],
                ]);

                $this->bodyDialog();

                \yii\bootstrap\Modal::end();
            } else if ($this->dialog == I18N::DIALOG_JQ) {
                \yii\jui\Dialog::begin([
                    'options' => [
                        'id' => 'dots-btn-modal',
                        'style' => 'display: none;',
                    ],
                    'clientOptions' => [
                        'autoOpen' => false,
                        'width' => '50%',
                    ],
                ]);

                $this->bodyDialog();

                \yii\jui\Dialog::end();
            } else if ($this->dialog == I18N::DIALOG_MAGNIFIC) {
                \pavlinter\translation\widgets\MagnificPopup::begin([
                    'toggleButton' => [
                        'id' => 'dots-btns',
                        'style' => 'display: none;',
                        'href' => '#dots-btn-modal',
                    ],
                    'popupClass' => 'dot-white-popup',
                    'effect' => 'zoom-in',
                    'popupOptions' => [
                        'class' => 'dots-modal-magnific',
                        'id' => 'dots-btn-modal',
                    ],
                ]);

                echo Html::beginTag('div', ['id' => 'dots-modal-header']);
                echo Html::tag('div', null, ['id' => 'dots-modal-cat-header']);
                echo Html::tag('div', null, ['id' => 'dots-modal-key-header']);
                echo Html::endTag('div');
                $this->bodyDialog();

                \pavlinter\translation\widgets\MagnificPopup::end();
            }



            if ($this->htmlScope) {
                echo Html::endTag('span');
            }

        });
        $this->showDot = true;
    }

    /**
     * @param $lang
     * @return bool
     */
    public function changeLanguage($lang)
    {
        if (is_numeric($lang)) {
            if (isset($this->languages[$lang])) {
                Yii::$app->language = $this->languages[$lang][$this->langColCode];
                $this->language     = $this->languages[$lang];
                $this->languageId   = $this->languages[$lang]['id'];
                return true;
            }
        } else if(is_string($lang)) {
            foreach ($this->languages as $language) {
                if ($language[$this->langColCode] === $lang) {
                    Yii::$app->language = $language[$this->langColCode];
                    $this->language     = $language;
                    $this->languageId   = $language['id'];
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Change language through $_GET params.
     */
    public function initLanguage()
    {
        $this->language = Yii::$app->language;
        $key = static::className().'Languages';
        $this->languages = Yii::$app->cache->get($key);

        if ($this->languages === false) {

            if ($this->langTable) {
                $query = new Query();
                $query->from($this->langTable)
                    ->where($this->langWhere)
                    ->orderBy($this->langOrder);

                $this->languages = $query->indexBy($this->langColCode)->all();
            } else {
                $this->languages = [];
            }

            if ($this->languages === []) {

                $this->languages['0'] = [
                    'id' => 0,
                    $this->langColCode  => $this->language,
                    $this->langColLabel => $this->language,
                ];
            }

            if ($this->enableCaching) {
                if ($this->langTable && $this->langColUpdatedAt) {

                    $query = new Query();
                    $sql = $query->select('COUNT(*),MAX(' . $this->langColUpdatedAt . ')')
                        ->from($this->langTable)
                        ->createCommand()
                        ->getRawSql();
                    Yii::$app->cache->set($key,$this->languages,$this->durationCaching,new DbDependency([
                        'sql' => $sql,
                    ]));
                } else if ($this->durationCaching) {
                    Yii::$app->cache->set($key,$this->languages,$this->durationCaching);
                }
            }
        }
        
        //        CUSTOM
        
        $query = new Query();
        $langs = $query->from($this->langTable)->where($this->langWhere)->indexBy($this->langColCode)->all();
        $req_url = preg_replace('~' . Yii::$app->request->baseUrl . '~', null, Yii::$app->request->url, 1);
        $req_url = substr($req_url, 1, 2);
        
        $langKey = isset($langs[$req_url]) ? $req_url : null;
        
        if ($this->languages) {
            $language = null;
            if (!$langKey) {
                $default_lang = SystemLanguage::getActiveItem();
                $langKey = $default_lang[$this->langColCode];
            }
            if ($langKey) {
                foreach ($this->languages as $l) {
                    if ($l[$this->langColCode] == $langKey) {
                        $language = $l;
                        break;
                    }
                }
                if ($language === null) {
                    Yii::$app->on(Application::EVENT_AFTER_REQUEST, function () {
                        throw new HttpException(404, 'Page not exists');
                    });
                }
            }
            if($language === null) {
                $language = reset($this->languages);
            }
            Yii::$app->language = $language[$this->langColCode];
            $this->language     = $language;
            $this->languageId   = $language['id'];
        }
        Yii::setAlias('weblang', Yii::getAlias('@web/' . Yii::$app->language));
    }
    /**
     * Translates a message to the specified language.
     *
     * After translation the message will be formatted using [[MessageFormatter]] if it contains
     * ICU message format and `$params` are not empty.
     *
     * @param string $category the message category.
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code (e.g. `en-US`, `en`).
     * @return string the translated and formatted message.
     */
    public function translate($category, $message, $params, $language)
    {
        $messageSource = $this->getMessageSource($category);
        $translation = $messageSource->translate($category, $message, $language);

        $mod = ArrayHelper::remove($params, 'dot');

        if (isset($params['br'])) {
            $nl2br = ArrayHelper::remove($params, 'br');
        } else {
            $nl2br = ArrayHelper::remove($params, 'nl2br' , $this->nl2br);
        }

        $settings = [
            'before' => '' ,
            'after' => '',
            'return' => false,
        ];

        $settings = ArrayHelper::merge($settings,$this->setDot($messageSource, $category, $message, $params, $mod));
        if ($settings['return']) {
            return $settings['before'].$settings['after'];
        }

        if ($translation === false) {
            if ($nl2br) {
                $message = nl2br($message);
            }
            return $settings['before'].$this->format($message, $params, $language).$settings['after'];
        } else {
            if ($nl2br) {
                $translation = nl2br($translation);
            }
            return $settings['before'].$this->format($translation, $params, $language).$settings['after'];
        }
    }
    /**
     * Returns the message source for the given category.
     * @param string $category the category name.
     * @return MessageSource the message source for the given category.
     * @throws InvalidConfigException if there is no message source available for the specified category.
     */
    public function getMessageSource($category)
    {
        if (isset($this->translations[$category])) {
            $source = $this->translations[$category];
            if (!($source instanceof MessageSource)) {
                $source = $this->translations[$category] = Yii::createObject($source);
            }
            return $source;
        } else {
            // try wildcard matching
            foreach ($this->translations as $pattern => $source) {
                if (strpos($pattern, '*') > 0 && strpos($category, rtrim($pattern, '*')) === 0) {
                    if (!($source instanceof MessageSource)) {
                        $source = $this->translations[$category] = $this->translations[$pattern] = Yii::createObject($source);
                    }
                    return $source;
                }
            }
            // match '*' in the last
            if (isset($this->translations['*'])) {
                $source = $this->translations['*'];
                if (!($source instanceof MessageSource)) {
                    $source = $this->translations[$category] = $this->translations['*'] = Yii::createObject($source);
                }
                return $source;
            }
        }

        throw new InvalidConfigException("Unable to locate message source for category '$category'.");
    }

    /**
     * @param $category
     * @param array $options
     * @return bool|string
     * @throws InvalidConfigException
     */
    public function getOnlyDots($category, $options = [])
    {
        /* @var $source \pavlinter\translation\DbMessageSource */
        $source = $this->getMessageSource($category);
        if ($source instanceof DbMessageSource) {

            $loop = ArrayHelper::remove($options, 'loop', '&nbsp;');
            $dot = ArrayHelper::merge([
                'dot' => '.',
                'dotRedirect' => 0,
            ], ArrayHelper::remove($options, 'dot', []));

            $messages = $source->getMessages();
            $res = '';
            foreach ($messages as $m => $id) {
                $res .= Yii::t($category, $m, $dot) . $loop;
            }
            return $res;
        }
        return false;
    }

    /**
     * @param $messageSource
     * @param $category
     * @param $message
     * @param $params
     * @param $mod
     * @return array
     */
    public function setDot($messageSource, $category, $message, &$params, $mod)
    {
        $redirect = ArrayHelper::remove($params, 'dotRedirect', 1);
        $dotHash = ArrayHelper::remove($params, 'dotHash', $this->getHash($category . $message));
        $dotTo = ArrayHelper::remove($params, 'dotTo', '');
        $var = ArrayHelper::remove($params, 'var', []);



        if ($mod === null) {
            if ($this->dotMode !== null) {
                $mod = $this->dotMode;
            } else {
                if ($messageSource instanceof DbMessageSource) {
                    $mod = $messageSource->dotMode;
                }
            }
        }

        $options = [
            'class' => $this->dotClass,
            'data-keys' => Json::encode(['category' => $category, 'message' => $message]),
            'data-redirect' => $redirect,
            'data-hash' => $dotHash,
            'data-var' => Json::encode($var),
            'data-params'=> Json::encode($params),
        ];

        if ($dotTo) {
            $options['data-to'] = $dotTo;
        }

        $this->dot = Html::tag('span', $this->dotSymbol, $options);
        $res = [];
        if (!$this->showDot) {
            if ($mod === '.') {
                $res['return'] = true;
            }
        } elseif ($mod === '.' && $this->dotMode === false) {
            $res['return'] = true;
        } elseif ($mod === true) {
            $res['before']  = Html::beginTag('span', ['class' => 'text-' . $options['class']]);
            $res['after']   = $this->dot = Html::endTag('span') . Html::tag('span', $this->dotSymbol, ArrayHelper::merge($options, ['data-redirect' => 0]));
        } elseif ($mod === '.') {
            $res['before']  = $this->dot;
            $res['return']  = true;
        }

        return $res;
    }
    /**
     * User permissions
     * @param  null|string|function
     * @return boolean
     */
    public function access($access = null)
    {
        if ($access === null) {
            $access = $this->access;
        }
        if (is_string($access) && Yii::$app->getAuthManager()!==null) {
            return Yii::$app->getUser()->can($access);
        } elseif (is_callable($access)) {
            return call_user_func($access);
        }
        return false;
    }

    /**
     * @param $category
     * @param $message
     * @return bool
     * @throws InvalidConfigException
     */
    public function getMessageId($category,$message)
    {
        $messageSource = $this->getMessageSource($category);

        if(method_exists($messageSource,'getId'))
        {
            return $messageSource->getId($category, $message);
        }
        return false;
    }

    /**
     * Generate hash for message;
     * @param $data
     * @return string
     */
    public function getHash($data)
    {
        return md5($data);
    }

    /**
     * Register client side
     * @param $view \yii\web\View
     */
    public function registerAssets($view)
    {
        $script = '';
        StyleAsset::register(Yii::$app->getView());
        if ($this->dialog == I18N::DIALOG_JQ) {
            $script = '
                if(jQuery("#dots-modal-header").length == 0){
                    jQuery("#dots-btn-modal").closest(".ui-dialog").find(".ui-dialog-title").html("<div id=\"dots-modal-header\"><div id=\"dots-modal-cat-header\"></div><div id=\"dots-modal-key-header\"></div></div>");
                }
            ';
        }

        if ($this->categoryUrl) {
           echo Html::a($this->categoryText, "javascript:void(0);", ['class' => 'dots-category-link', 'style' => 'display: none;', 'target' => '_blank']);
        }

        $showPopup = '';
        $hidePopup = '';
        if ($this->dialog == I18N::DIALOG_BS) {
            $showPopup = 'jQuery("#dots-btns").trigger("click");';
            $hidePopup = 'jQuery("#dots-btn-modal").modal("hide");';
        } else if ($this->dialog == I18N::DIALOG_JQ) {
            $showPopup = 'jQuery("#dots-btn-modal").dialog();';
            $hidePopup = 'jQuery("#dots-btn-modal").dialog("close");';
        } else if ($this->dialog == I18N::DIALOG_MAGNIFIC) {
            $showPopup = 'jQuery("#dots-btns").trigger("click");';
            $hidePopup = '$.magnificPopup.close();';
        }

        $request = Yii::$app->getRequest();




        $view->registerJs('
            var dotBtn = {
                text: "' . Yii::t("i18n-dot", "Change", ['dot' => false]) . '",
                loading : "' . Yii::t("i18n-dot", "Loading...", ['dot' => false]) . '"
            };
            var dotCategoryUrl = "' . Url::to($this->categoryUrl) . '";
            var langCode = "' . $this->language[$this->langColCode] . '";

            jQuery("#dot-translation-form button").on("click", function () {

                var form        = jQuery(this).closest("form");
                var hash        = form.attr("data-hash");
                var dotTo       = form.attr("data-to");
                var redirect    = form.attr("data-redirect")==1;

                jQuery("#dot-btn",form).prop("disabled", true).text(dotBtn.loading);

                jQuery.ajax({
                    url: form.attr("action"),
                    type: "POST",
                    dataType: "json",
                    data: form.serialize(),
                }).done(function(d) {
                    if (!dotTo && redirect) {
                        location.href = "'.Url::to('').'";
                        return false;
                    }

                    if (d.r) {
                        var val = d.message;
                        var $dot = jQuery("[data-hash=\'" + hash + "\']").not(form);
                        var $dotTo = jQuery("[data-hash=\'" + dotTo + "\']");
                        var params = $dot.attr("data-params");
                        if (params) {
                            var o = jQuery.parseJSON(params);
                            for (m in o) {
                                if(val !== null){
                                    val = val.replace("{" + m + "}",o[m]);
                                }
                            }
                        }
                        $dot.prev(".text-' . $this->dotClass . '").html(val);
                        jQuery("#dot-btn",form).text(dotBtn.text).prop("disabled", false);
                        $dotTo.html(val);
                        ' . $hidePopup . '
                    }
                });

                return false;

            });

            jQuery(document).on("click",".'.$this->dotClass.'",function () {
                '.$script.'
                var $catLink    = jQuery(".dots-category-link");
                var $form       = jQuery("#dot-translation-form");
                var $varCont    = jQuery("#dots-variables");
                var $el         = jQuery(this);
                var k           = jQuery.parseJSON($el.attr("data-keys"));
                var variables   = jQuery.parseJSON($el.attr("data-var"));
                var hash        = $el.attr("data-hash");
                var redirect    = $el.attr("data-redirect");
                var dotTo       = $el.attr("data-to");
                var $textarea   = jQuery("#dot-translation-form textarea").val(dotBtn.loading);
                var $key        = jQuery("#dots-modal-header #dots-modal-key-header")
                var viewMsg     = k.message.replace(/<br\s*[\/]?>/gi, "\n");
                $form.attr("data-redirect",redirect);
                $form.attr("data-hash", hash);
                $form.attr("data-to", dotTo);

                if($catLink.is(":hidden")){
                    $catLink.show().appendTo(jQuery("#dots-modal-header"));
                }

                $varCont.hide();
                $varCont.text("");

                k.message = encodeURIComponent(k.message);

                jQuery("#dot-translation-form #dots-inp-category").val(k.category);
                jQuery("#dot-translation-form #dots-inp-message").val(k.message);

                $catLink.attr("href", dotCategoryUrl.replace("{lang}", langCode).replace("{category}", k.category).replace("{message}", k.message))

                if(variables){
                    for(v in variables){
                        if(jQuery.isNumeric(v)){
                            $varCont.append("<div class=\"dots-var\">{" + variables[v] +"}</div>");
                        } else {
                            $varCont.append("<div class=\"dots-var\">{" + v + "} - " + variables[v] + "</div>");
                        }

                    }
                    $varCont.show();
                }


                $key.text(viewMsg);
//                $key.html($key.html().replace(/\n/g,"<br/>"));

                ' . $showPopup . '

                jQuery.ajax({
                    url: $form.attr("action"),
                    type: "POST",
                    dataType: "json",
                    data: k,
                }).done(function(d) {
                    $textarea.val("");
                    var $dotHeader = jQuery("#dots-modal-header #dots-modal-cat-header")

                    if (d.adminLink){
                        var $adminLinkForm = jQuery("<form method=\"post\" action=\"" + d.adminLink + "\" target=\"_blank\"><input type=\"hidden\" name=\"category\" value=\"" + k.category + "\" /><input type=\"hidden\" name=\"message\" value=\"" + k.message + "\" /><input type=\"hidden\" name=\"'.$request->csrfParam.'\" value=\"'.$request->getCsrfToken().'\" /><a href=\"javascript:void(0);\">" + k.category + "</a></form>");
                        $adminLinkForm.find("a").on("click", function(){
                            jQuery(this).closest("form").submit();
                            return false;
                        });
                        $dotHeader.html($adminLinkForm);
                    } else {
                        $dotHeader.text(k.category);
                    }

                    for(m in d.fields){
                        val = d.fields[m];
                        if(val == ""){
                            jQuery(m).addClass("emptyField").val(val);
                        }else{
                            jQuery(m).removeClass("emptyField").val(val);
                        }
                        var $isEmpty = jQuery(m).parent().find(".empty_checkbox");
                        if(val === null){
                            $isEmpty.prop("checked", true);
                        } else {
                            $isEmpty.prop("checked", false);
                        }
                    }
                });
                return false;
            });
            jQuery("#dot-translation-form textarea").on("focus",function(){
                jQuery(this).removeClass("emptyField");
            });
        ');
    }

    /**
     *
     */
    private function bodyDialog()
    {
        ActiveForm::begin([
            'id' => 'dot-translation-form',
            'action' => [$this->router],
        ]);
        echo Html::tag('div',null,['id' => 'dots-filter']);
        echo Html::hiddenInput('category', '', ['id' => 'dots-inp-category']);
        echo Html::hiddenInput('message', '', ['id' => 'dots-inp-message']);
        echo Html::tag('div', null ,['id' => 'dots-variables']);
        foreach ($this->languages as $id_language => $language) {

            echo Html::beginTag('div', ['class' => 'form-group']);
            echo Html::beginTag('div', ['class' => 'is_empty_cont']);
            echo Html::label(Yii::t("i18n-dot", "Empty", ['dot' => false]), 'is_empty_' . $id_language, ['class' => 'is_empty_label']);
            echo Html::checkbox('is_empty[' . $id_language . ']', false, ['class' => 'empty_checkbox', 'id' => 'is_empty_' . $id_language, 'uncheck' => 0]);
            echo Html::endTag('div');
            echo Html::label($language[$this->langColLabel],'dot-translation-' . $id_language);
            echo Html::textarea('translation[' . $id_language . ']', '', [
                'class' => 'form-control',
                'id' => 'dot-translation-' . $id_language]);
            echo Html::endTag('div');
        }
        echo Html::submitButton(Yii::t("i18n-dot", "Change", ['dot' => false]), ['class' => 'btn btn-primary', 'id' => 'dot-btn']);

        ActiveForm::end();
    }

    /**
     * @return array|string
     */
    public function isPjax()
    {
        $headers = Yii::$app->getRequest()->getHeaders();
        return $headers->get('X-Pjax');
    }
    /**
     * @param $id
     * @param $data
     */
    public function setLanguage($id, $data)
    {
        $this->languages[$id] = $data;
    }

    /**
     * @param null $id
     * @return array|string fields|field from language table
     */
    public function getLanguage($id = null)
    {
        if ($id !== null && isset($this->languages[$id])) {
            return $this->languages[$id];
        } else {
            return $this->languages[Yii::$app->language];
        }
    }

    /**
     * @param bool|callable $callable function($language, $id){return $language;}
     * if set true, created current url
     * @return array
     */
    public function getLanguages($callable = false)
    {
        $languages = $this->languages;
        if (is_callable($callable)) {
            foreach ($languages as $id => $language) {
                $languages[$id] = call_user_func($callable, $language, $id);
            }
        } elseif ($callable == true) {
            $curr_lang = Yii::$app->language;
            
            foreach ($languages as $id => $language) {
                $this->changeLanguage($id);
                new \frontend\components\LocalisedRoutes;
                
                if (!isset($languages[$id]['url'])) {
                    $languages[$id]['url'] = Url::current([$this->langParam => $language[$this->langColCode]]);
                }
            }
            
            $this->changeLanguage($curr_lang);
            new \frontend\components\LocalisedRoutes;
        }
        return $languages;
    }

    /**
     * @param callable $callable function($menuRow, $language, $id){ return $menuRow;}
     * @return array for \yii\widgets\Menu
     */
    public function menuItems(callable $callable = null)
    {
        $languages = $this->getLanguages(true);
        $menu = [];
        if ($callable) {
            foreach ($languages as $id => $language) {
                $text = $language[$this->langColCode];
                if ($language[$this->langColImage]) {
                    $text = Html::img($language[$this->langColImage]);
                }
                $menuRow = [
                    'label' => $text,
                    'url' => $language['url'],
                ];
                $menu[] = call_user_func($callable, $menuRow, $language, $id);
            }
        } else {
            foreach ($languages as $id => $language) {
                $text = $language[$this->langColCode];
                if ($language[$this->langColImage]) {
                    $text = Html::img($language[$this->langColImage]);
                }
                $menu[] = [
                    'label' => $text,
                    'url' => $language['url'],
                ];
            }
        }
        return $menu;
    }

    /**
     * @return int language id from language table
     */
    public function getId()
    {
        return $this->languageId;
    }
    /**
     * @return string the previous dot target
     */
    public function getPrevDot()
    {
        if ($this->access()) {
            return $this->dot;
        }
        return null;
    }
    /**
     * Force disable all dots
     */
    public function disableDot()
    {
        $this->dotMode = false;
    }
    /**
     * Force enable all dots
     */
    public function enableDot()
    {
        $this->dotMode = true;
    }
    /**
     * Set global previous settings
     */
    public function resetDot()
    {
        $this->dotMode = null;
    }
}
