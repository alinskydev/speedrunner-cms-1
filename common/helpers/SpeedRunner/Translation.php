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
    public function languages()
    {
        $langs = SystemLanguage::find()->andWhere(['is_active' => 1])->indexBy('code')->asArray()->all();
        $lang_current = Yii::$app->language;
        
        foreach ($langs as $key => $l) {
            Yii::$app->language = $key;
            new \frontend\components\LocalisedRoutes;
            
            $langs[$key]['url'] = Yii::$app->urlManager->createUrl([Yii::$app->requestedRoute, 'lang' => $key]);
        }
        
        Yii::$app->language = $lang_current;
        
        return $langs;
    }
}
