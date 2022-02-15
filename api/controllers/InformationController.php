<?php

namespace api\controllers;

use Yii;
use speedrunner\controllers\RestController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemSettings;
use backend\modules\System\models\SystemLanguage;
use backend\modules\Staticpage\models\Staticpage;

/**
* Here you can find information about:
* - System settings
* - Languages
* - Static pages
*/
class InformationController extends RestController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ]);
    }
    
    public function actionIndex()
    {
        return [
            'settings' => SystemSettings::find()->andWhere(['not in', 'name', ['delete_model_file']])->orderBy('sort')->indexBy('name')->all(),
            'languages' => Yii::$app->services->i18n::$languages,
            'staticpages' => Staticpage::find()->select(['name', 'label'])->indexBy('name')->asObject()->all(),
        ];
    }
}
