<?php

namespace backend\modules\Menu\controllers;

use Yii;
use speedrunner\controllers\NestedSetsController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Menu\models\Menu;


class MenuController extends NestedSetsController
{
    public function init()
    {
        $this->model = new Menu();
        return parent::init();
    }
}
