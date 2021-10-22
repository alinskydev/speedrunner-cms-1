<?php

namespace backend\modules\Blog\controllers;

use Yii;
use speedrunner\controllers\CrudController;
use speedrunner\actions as Actions;
use yii\helpers\ArrayHelper;

use backend\modules\Blog\models\BlogTag;


class TagController extends CrudController
{
    public function init()
    {
        $this->model = new BlogTag();
        return parent::init();
    }
    
    public function actions()
    {
        return ArrayHelper::filter(parent::actions(), ['index', 'create', 'update', 'delete']);
    }
}
