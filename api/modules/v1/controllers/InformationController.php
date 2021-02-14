<?php

namespace api\modules\v1\controllers;

use Yii;
use common\controllers\RestController;
use common\actions as Actions;
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
            'settings' => SystemSettings::find()->andWhere(['not in', 'name', ['delete_model_file']])->all(),
            'languages' => SystemLanguage::find()->all(),
            'static_pages' => Staticpage::find()->select(['name', 'label'])->asArray()->all(),
        ];
    }
}
