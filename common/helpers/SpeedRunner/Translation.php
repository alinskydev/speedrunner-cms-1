<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\db\Query;

use backend\modules\System\models\SystemLanguage;
use backend\modules\Translation\models\TranslationMessage;


class Translation
{
    public $languages;
    
    public function __construct()
    {
        $languages = SystemLanguage::find()->andWhere(['is_active' => 1])->indexBy('code')->asArray()->all();
        $current_language = Yii::$app->language;
        
        foreach ($languages as $key => $l) {
            Yii::$app->language = $key;
            new \frontend\components\LocalisedRoutes;
            
            $languages[$key]['url'] = Yii::$app->urlManager->createUrl([Yii::$app->requestedRoute, 'lang' => $key]);
        }
        
        Yii::$app->language = $current_language;
        $this->languages = $languages;
    }
}
