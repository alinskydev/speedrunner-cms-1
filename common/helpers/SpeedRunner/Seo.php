<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use backend\modules\Seo\models\SeoMeta;


class Seo
{
    public function getMeta($model)
    {
        $model_class = StringHelper::basename($model->className());
        
        $seo_meta_mdl = SeoMeta::find()
            ->andWhere([
                'model_class' => $model_class,
                'model_id' => $model->id,
                'lang' => Yii::$app->language
            ])
            ->one();
        
        return ArrayHelper::getValue($seo_meta_mdl, 'value', []);
    }
    
    public function registerMeta($model)
    {
        $seo_meta = $this->getMeta($model);
        
        foreach ($seo_meta as $key => $s_m) {
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
