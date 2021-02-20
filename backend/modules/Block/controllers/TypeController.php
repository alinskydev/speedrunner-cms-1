<?php

namespace backend\modules\Block\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Block\models\BlockType;


class TypeController extends CrudController
{
    public function init()
    {
        $this->model = new BlockType();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'update']);
    }
}
