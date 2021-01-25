<?php

namespace backend\modules\System\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\ArrayHelper;


class SystemSettings extends ActiveRecord
{
    use \api\modules\v1\models\system\SystemSettings;
    
    public static function tableName()
    {
        return 'SystemSettings';
    }
    
    public function rules()
    {
        return [
            [['label'], 'required'],
            [['sort'], 'integer'],
            [['label', 'value'], 'string', 'max' => 100],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'name' => Yii::t('app', 'Name'),
            'label' => Yii::t('app', 'Label'),
            'value' => Yii::t('app', 'Value'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
