<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\modules\User\models\User;


class ProfileForm extends Model
{
    public $user;
    public $attrs = ['full_name', 'phone', 'address', 'image'];
    
    public $new_password;
    public $confirm_password;
    
    public $full_name;
    public $phone;
    public $address;
    public $image;
    
    public function init()
    {
        if ($this->user) {
            foreach ($this->attrs as $a) {
                $this->{$a} = $this->user->{$a};
            }
        }
    }
    
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['full_name', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024],
            [['new_password'], 'string', 'min' => 6, 'max' => 50],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'image' => Yii::t('app', 'Image'),
            
            'new_password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
        ];
    }

    public function beforeValidate()
    {
        if ($image = UploadedFile::getInstance($this, 'image')) {
            $this->image = $image;
        }
        
        return parent::beforeValidate();
    }
    
    public function update()
    {
        $user = $this->user;
        
        foreach ($this->attrs as $a) {
            $user->{$a} = $this->{$a};
        }
        
        $user->new_password = $this->new_password;
        
        //        IMAGE
        
        $old_image = ArrayHelper::getValue($user->profile, 'image', null);
        
        if ($image = UploadedFile::getInstance($this, 'image')) {
            $user->image = Yii::$app->sr->file->save($image, 'files/profile');
            Yii::$app->sr->file->delete($old_image);
        }
        
        return $this->user->save();
    }
}
