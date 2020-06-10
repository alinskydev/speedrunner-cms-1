<?php
 
namespace frontend\components;
 
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

 
class LocalisedRoutes extends Component
{
    public function init()
    {
//        $routes = [
//            Yii::t('routes', 'contact') => 'site/contact',
//            Yii::t('routes', 'about') => 'site/about',
//        ];
//        
//        $urlManager = $_SERVER['REDIRECT_APP'] == 'frontend' ? Yii::$app->urlManager : Yii::$app->urlManagerFrontend;
//        $urlManager->rules = ArrayHelper::index($urlManager->rules, 'route');
//        
//        foreach ($routes as $key => $r) {
//            ArrayHelper::remove($urlManager->rules, $r);
//        }
//        
//        $urlManager->addRules($routes);
//        
//        return parent::init();
    }
}