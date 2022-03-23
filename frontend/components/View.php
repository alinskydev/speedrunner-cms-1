<?php

namespace frontend\components;

use Yii;
use yii\helpers\ArrayHelper;


class View extends \yii\web\View
{
    public function head()
    {
        echo ArrayHelper::getValue($this->params, 'seo_meta.global.head');
        echo ArrayHelper::getValue($this->params, 'seo_meta.page.head');
        
        parent::head();
    }
    
    public function endBody()
    {
        echo ArrayHelper::getValue($this->params, 'seo_meta.global.body');
        echo ArrayHelper::getValue($this->params, 'seo_meta.page.body');
        
        parent::endBody();
    }
}