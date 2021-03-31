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
    
    public function beginBody()
    {
        echo ArrayHelper::getValue($this->params, 'seo_meta.global.body.top');
        echo ArrayHelper::getValue($this->params, 'seo_meta.page.body.top');
        
        parent::beginBody();
    }
    
    public function endBody()
    {
        echo ArrayHelper::getValue($this->params, 'seo_meta.global.body.bottom');
        echo ArrayHelper::getValue($this->params, 'seo_meta.page.body.bottom');
        
        parent::endBody();
    }
}