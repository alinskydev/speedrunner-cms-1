<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class FilesBehavior extends Behavior
{
    public $attributes;
    
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }
    
    public function beforeValidate($event)
    {
        foreach ($this->attributes as $a) {
            if ($value = UploadedFile::getInstances($this->owner, $a)) {
                $this->owner->{$a} = $value;
            }
        }
    }
    
    public function beforeSave($event)
    {
        foreach ($this->attributes as $a) {
            $old_value = ArrayHelper::getValue($this->owner->oldAttributes, $a, []);
            $new_value = [];
            
            if ($value = UploadedFile::getInstances($this->owner, $a)) {
                foreach ($value as $v) {
                    $new_value[] = Yii::$app->sr->file->save($v);
                }
                
                $this->owner->{$a} = array_merge($old_value, $new_value);
            } else {
                $this->owner->{$a} = $old_value;
            }
        }
    }
    
    public function afterDelete($event)
    {
        foreach ($this->attributes as $a) {
            foreach ($this->owner->{$a} as $value) {
                Yii::$app->sr->file->delete($value);
            }
        }
    }
}
