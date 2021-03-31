<?php

namespace speedrunner\behaviors;

use Yii;
use yii\base\Behavior;
use speedrunner\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class FileBehavior extends Behavior
{
    public array $attributes;
    public bool $multiple;
    public string $save_dir = 'uploaded';
    
    public array $width_height = [];
    
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
        $method = $this->multiple ? 'getInstances' : 'getInstance';
        
        foreach ($this->attributes as $a) {
            if ($value = forward_static_call([UploadedFile::className(), $method], $this->owner, $a)) {
                $this->owner->{$a} = $value;
            }
        }
    }
    
    public function beforeSave($event)
    {
        if ($this->multiple) {
            foreach ($this->attributes as $a) {
                $old_value = ArrayHelper::getValue($this->owner->oldAttributes, $a, []);
                $new_value = [];
                
                if ($value = UploadedFile::getInstances($this->owner, $a)) {
                    foreach ($value as $v) {
                        $new_value[] = Yii::$app->services->file->save($v, $this->save_dir, $this->width_height);
                    }
                    
                    $this->owner->{$a} = array_merge($old_value, $new_value);
                } else {
                    $this->owner->{$a} = $old_value;
                }
            }
        } else {
            foreach ($this->attributes as $a) {
                $old_value = ArrayHelper::getValue($this->owner, "oldAttributes.$a");
                
                if ($value = UploadedFile::getInstance($this->owner, $a)) {
                    $this->owner->{$a} = Yii::$app->services->file->save($value, $this->save_dir, $this->width_height);
                    Yii::$app->services->file->delete($old_value);
                } else {
                    $this->owner->{$a} = $this->owner->{$a} ?: $old_value;
                }
            }
        }
    }
    
    public function afterDelete($event)
    {
        if ($this->multiple) {
            foreach ($this->attributes as $a) {
                foreach ($this->owner->{$a} as $value) {
                    Yii::$app->services->file->delete($value);
                }
            }
        } else {
            foreach ($this->attributes as $a) {
                Yii::$app->services->file->delete($this->owner->{$a});
            }
        }
    }
}
