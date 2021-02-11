<?php

namespace common\services;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemLanguage;


class I18NService
{
    public static $languages = null;
    private static $routes;
    
    public function __construct()
    {
        if (static::$languages === null) {
            $languages = Yii::$app->urlManager->languages;
            $current_language = Yii::$app->language;
            
            foreach ($languages as $key => $l) {
                Yii::$app->language = $key;
                $this->setLocalizedRoutes();
                
                $languages[$key]['url'] = Yii::$app->urlManager->createUrl(ArrayHelper::merge(
                    [Yii::$app->requestedRoute],
                    Yii::$app->request->get(),
                    ['lang' => $key]
                ));
            }
            
            Yii::$app->language = $current_language;
            static::$languages = $languages;
        }
    }
    
    public static function setLocalizedRoutes()
    {
//        static::$routes = [
//            Yii::t('app', 'Name') => 'site/contact',
//        ];
//        
//        $urlManager = Yii::$app->id == 'app-frontend' ? Yii::$app->urlManager : Yii::$app->urlManagerFrontend;
//        $urlManager->rules = ArrayHelper::index($urlManager->rules, 'route');
//        
//        foreach (static::$routes as $r) {
//            ArrayHelper::remove($urlManager->rules, $r);
//        }
//        
//        $urlManager->addRules(static::$routes);
    }
}
