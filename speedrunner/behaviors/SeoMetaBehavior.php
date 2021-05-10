<?php

namespace speedrunner\behaviors;

use Yii;
use yii\base\Behavior;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

use backend\modules\Seo\models\SeoMeta;


class SeoMetaBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    
    public function afterSave($event)
    {
        $filter = [
            'model_class' => StringHelper::basename($this->owner->className()),
            'model_id' => $this->owner->id,
            'lang' => Yii::$app->language,
        ];
        
        $seo_model = SeoMeta::find()->andWhere($filter)->one() ?? new SeoMeta($filter);
        $seo_model->value = Yii::$app->request->post('SeoMeta');
        $seo_model->save();
    }
    
    public function afterDelete($event)
    {
        $model_class = StringHelper::basename($this->owner->className());
        SeoMeta::deleteAll(['model_class' => $model_class, 'model_id' => $this->owner->id]);
    }
}
