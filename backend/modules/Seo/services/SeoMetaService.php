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
    
    public function getMetaValue($is_for_update = false)
    {
        $lang = Yii::$app->language;
        $model = SeoMeta::find()
            ->andWhere([
                'model_class' => StringHelper::basename($this->model->className()),
                'model_id' => $this->model->id,
            ])
            ->one();
        
        return ArrayHelper::getValue($model, $is_for_update ? 'value' : "value.$lang", []);
    }
}
