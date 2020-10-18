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
//            Yii::t('app_routes', 'contact') => 'site/contact',
//        ];
//        
//        $urlManager = Yii::$app->urlManager->baseUrl == Yii::$app->urlManagerFrontend->baseUrl ? Yii::$app->urlManager : Yii::$app->urlManagerFrontend;
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