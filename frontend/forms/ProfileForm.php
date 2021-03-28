<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\modules\User\models\User;


class ProfileForm extends Model
{
    const PROFILE_ATTRIBUTES = ['full_name', 'phone', 'address', 'image'];
    
    public $user;
    
    public $full_name;
    public $phone;
    public $address;
    public $image;
    
    public $new_password;
    public $confirm_password;
    
    public function init()
    {
        if (!($this->user = Yii::$app->user->identity)) {
            throw new InvalidParamException(Yii::t('app', 'Not authorized'));
        }
        
        foreach (self::PROFILE_ATTRIBUTES as $a) {
            $this->{$a} = $this->user->{$a};
        }
        
        return parent::init();
    }
    
    public function formName()
    {
        return 'User';
    }
    
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            [['confirm_password'], 'required', 'enableClientValidation' => false, 'when' => fn ($model) => $model->new_password],
            
            [['full_name', 'phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 1000],
            [['image'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 1024 * 1024],
            [['new_password'], 'string', 'min' => 8, 'max' => 50],
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
        
        foreach (self::PROFILE_ATTRIBUTES as $a) {
            $user->{$a} = $this->{$a};
        }
        
        $user->new_password = $this->new_password;
        
        return $user->save() ? $user : false;
    }
}
