<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use backend\modules\User\models\User;


class ResetPasswordForm extends Model
{
    public $password;
    public $confirm_password;
    
    private $_user;
    
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('app', 'Password reset token cannot be blank'));
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('app', 'Wrong password reset token'));
        }
        parent::__construct($config);
    }
    
    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
            [['password'], 'string', 'min' => 6, 'max' => 50],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
        ];
    }
    
    public function resetPassword()
    {
        $user = $this->_user;
        $user->new_password = $this->password;
        $user->removePasswordResetToken();
        $user->save(false);
        
        return Yii::$app->user->login($user, 3600 * 24 * 30);
    }
}
