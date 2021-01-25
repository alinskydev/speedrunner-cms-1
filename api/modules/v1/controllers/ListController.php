<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;

use backend\modules\System\models\SystemSettings;
use backend\modules\System\models\SystemLanguage;
use backend\modules\Staticpage\models\Staticpage;


class ListController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
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
