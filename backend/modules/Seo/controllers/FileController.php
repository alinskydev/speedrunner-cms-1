<?php

namespace backend\modules\Seo\controllers;

use Yii;
use yii\web\Controller;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Seo\forms\SeoFileForm;


class FileController extends Controller
{
    public function actions()
    {
        return [
            'update' => [
                'class' => Actions\web\FormAction::className(),
                'model_class' => SeoFileForm::className(),
                'render_view' => 'update',
                'run_method' => 'update',
                'success_message' => 'Files have been updated',
                'redirect_route' => ['update'],
            ],
        ];
    }
}
