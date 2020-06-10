<?php
 
namespace common\components;
 
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use backend\modules\System\models\SystemSettings;


class Settings extends Component
{
    private $_attributes;
    
    public function init()
    {
        parent::init();
        $this->_attributes = ArrayHelper::map(SystemSettings::find()->select(['name', 'value'])->asArray()->all(), 'name', 'value');
    }
    
    public function __get($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }
}