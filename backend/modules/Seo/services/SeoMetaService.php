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
        foreach ($this->getMetaValue() as $key => $s_m) {
            switch ($key) {
                case 'title':
                    Yii::$app->view->title = $s_m;
                    break;
                case 'description':
                case 'keywords':
                    Yii::$app->view->registerMetaTag([
                        'name' => $key,
                        'content' => $s_m,
                    ]);
                    break;
                case 'og:image':
                    Yii::$app->view->registerMetaTag([
                        'property' => $key,
                        'content' => $s_m ? Yii::$app->urlManager->createAbsoluteFileUrl($s_m) : null,
                    ]);
                    break;
                default:
                    Yii::$app->view->registerMetaTag([
                        'property' => $key,
                        'content' => $s_m,
                    ]);
            }
        }
    }
}
