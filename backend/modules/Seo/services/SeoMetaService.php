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
    
    public function register()
    {
        $seo_meta = $this->getMetaValue();
        $seo_meta_types = (new SeoMeta())->enums->types();
        
        foreach ($seo_meta_types as $key => $s_m_t) {
            $value = ArrayHelper::getValue($seo_meta, $key);
            
            switch ($s_m_t['register_type']) {
                case 'title':
                    Yii::$app->view->title = $value;
                    break;
                    
                case 'name':
                    Yii::$app->view->registerMetaTag([
                        'name' => $key,
                        'content' => $value,
                    ]);
                    break;
                    
                case 'property':
                    Yii::$app->view->registerMetaTag([
                        'property' => $key,
                        'content' => $value,
                    ]);
                    break;
                    
                case 'url':
                    Yii::$app->view->registerMetaTag([
                        'property' => $key,
                        'content' => $value ? Yii::$app->urlManager->createAbsoluteFileUrl($value) : null,
                    ]);
                    break;
            }
        }
    }
}
