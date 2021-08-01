<?php

namespace backend\modules\User\models;

use Yii;
use speedrunner\db\ActiveRecord;


class UserRole extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_role}}';
    }
    
    public function init()
    {
        $this->routes = [];
        return parent::init();
    }
    
    public function behaviors()
    {
        return [
            'translation' => [
                'class' => \speedrunner\behaviors\TranslationBehavior::className(),
                'attributes' => ['name'],
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['routes'], 'default', 'value' => []],
            [['routes'], 'in', 'range' => Yii::$app->helpers->array->leaves($this->enums->routes()), 'allowArray' => true],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'routes' => Yii::t('app', 'Routes'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }
    
    public function beforeDelete()
    {
        if ($this->id == 1) {
            Yii::$app->session->addFlash('danger', Yii::t('app', 'You cannot delete this record'));
            return false;
        }
        
        if (User::find()->andWhere(['role_id' => $this->id])->exists()) {
            Yii::$app->session->addFlash('warning', Yii::t('app', 'You cannot delete record which contains any users'));
            return false;
        }
        
        return parent::beforeDelete();
    }
}
