<?php

namespace backend\modules\Seo\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use speedrunner\db\ActiveRecord;

use backend\modules\Seo\models\SeoMeta;


class SeoMetaService
{
    private $model;
    
    public function __construct(ActiveRecord $model)
    {
        $this->model = $model;
    }
    
    public function getMetaValue()
    {
        $seo_meta_mdl = SeoMeta::find()
            ->andWhere([
                'model_class' => StringHelper::basename($this->model->className()),
                'model_id' => $this->model->id,
                'lang' => Yii::$app->language,
            ])
            ->one();
        
        return ArrayHelper::getValue($seo_meta_mdl, 'value', []);
    }
    
    public function register($group = 'page')
    {
        $seo_meta = $this->getMetaValue();
        
        Yii::$app->view->params['seo_meta'][$group] = [
            'head' => ArrayHelper::getValue($seo_meta, 'head'),
            'body' => [
                'top' => ArrayHelper::getValue($seo_meta, 'body_top'),
                'bottom' => ArrayHelper::getValue($seo_meta, 'body_bottom'),
            ],
        ];
    }
}
