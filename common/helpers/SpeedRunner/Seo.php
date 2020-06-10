<?php

namespace common\helpers\SpeedRunner;

use Yii;
use yii\helpers\StringHelper;
use backend\modules\Seo\models\SeoMeta;


class Seo
{
    public function getMeta($model)
    {
        $model_class = StringHelper::basename($model->className());
        
        $seo_meta_mdl = SeoMeta::find()
            ->where([
                'model_class' => $model_class,
                'model_id' => $model->id,
                'lang' => Yii::$app->language
            ])
            ->one();
        
        return $seo_meta_mdl ? json_decode($seo_meta_mdl->value, JSON_UNESCAPED_UNICODE) : [];
    }
    
    public function getMetaLayout($model)
    {
        return Yii::$app->controller->renderPartial('@backend/modules/Seo/views/meta/meta', ['seo_meta' => $this->getMeta($model)]);
    }
    
    public function registerMeta($model)
    {
        $seo_meta = $this->getMeta($model);
        
        foreach ($seo_meta as $key => $s_m) {
            switch ($key) {
                case 'title':
                    Yii::$app->view->title = $s_m['content'];
                    break;
                case 'og:image':
                    $s_m['content'] = $s_m['content'] ? Yii::$app->urlManager->createAbsoluteLanglessUrl($s_m['content']) : null;
                    Yii::$app->view->registerMetaTag($s_m);
                    break;
                default:
                    Yii::$app->view->registerMetaTag($s_m);
                    break;
            }
        }
    }
    
    public function saveMeta($model, $value)
    {
        $model_class = StringHelper::basename($model->className());
        
        $seo_mdl = SeoMeta::find()
            ->where([
                'model_class' => $model_class,
                'model_id' => $model->id,
                'lang' => Yii::$app->language
            ])
            ->one() ?: new SeoMeta;
        
        $seo_mdl->model_class = $model_class;
        $seo_mdl->model_id = $model->id;
        $seo_mdl->lang = Yii::$app->language;
        $seo_mdl->value = json_encode($value, JSON_UNESCAPED_UNICODE);
        $seo_mdl->save();
    }
    
    public function deleteMeta($model)
    {
        $model_class = StringHelper::basename($model->className());
        SeoMeta::deleteAll(['model_class' => $model_class, 'model_id' => $model->id]);
    }
}
