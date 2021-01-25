<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\services\FileService;


class FilesBehavior extends Behavior
{
    public $save_dir = 'uploaded';
    public $width_height = [];
    
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
                    $new_value[] = (new FileService($v))->save($this->save_dir, $this->width_height);
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
                FileService::delete($value);
            }
        }
    }
}
