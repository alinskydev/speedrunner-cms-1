<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;

use backend\modules\User\models\User;


class ProfileForm extends Model
{
    public $user;
    public $attrs = ['username', 'full_name', 'phone', 'address'];
    
    public $username;
    public $new_password;
    public $confirm_password;
    
    public $full_name;
    public $phone;
    public $address;
    
    
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
            [['username'], 'required'],
            [['full_name', 'phone'], 'string', 'max' => 100],
            [['username', 'address'], 'string', 'max' => 255],
            [['new_password'], 'string', 'min' => 6, 'max' => 50],
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password'],
            
            [['username'], 'unique', 'targetClass' => User::className(), 'filter' => function ($query) {
                $query->andWhere(['!=', 'id', $this->user->id]);
            }, 'message' => Yii::t('app', 'This username has already been taken')],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'new_password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
            
            'full_name' => Yii::t('app', 'Full name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
        ];
    }
    
    public function update()
    {
        foreach ($this->attrs as $a) {
            $this->user->{$a} = $this->{$a};
        }
        
        $this->user->new_password = $this->new_password;
        
        return $this->user->save();
    }
}
