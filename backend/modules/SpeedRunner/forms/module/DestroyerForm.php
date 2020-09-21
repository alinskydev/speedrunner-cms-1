<?php

namespace backend\modules\Speedrunner\forms\module;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;


class DestroyerForm extends Model
{
    public $modules;
    
    public function rules()
    {
        return [
            [['modules'], 'required'],
            [['modules'], 'in', 'range' => array_keys($this->modulesList()), 'allowArray' => true],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'modules' => Yii::t('speedrunner', 'Modules'),
        ];
    }
    
    static function modulesList()
    {
        foreach (Yii::$app->modules as $key => $m) {
            if (!in_array($key, ['rbac', 'debug', 'gii', 'speedrunner', 'staticpage', 'system', 'user', 'seo'])) {
                $result[ucfirst($key)] = ucfirst($key);
            }
        }
        
        return $result;
    }
    
    public function process()
    {
        foreach ($this->modules as $m) {
            $module = strtolower($m);
            
            //        FILES
            
            if ($dir = Yii::getAlias("@backend/modules/$module")) {
                FileHelper::removeDirectory($dir);
            }
            
            //        DB
            
            $tables = Yii::$app->db->schema->getTableNames();
            $sql = 'SET FOREIGN_KEY_CHECKS = 0;';
            
            foreach ($tables as $t) {
                if (strpos($t, $m) === 0) {
                    $sql .= "DROP TABLE $t;";
                }
            }
            
            $sql .= 'SET FOREIGN_KEY_CHECKS = 1;';
            Yii::$app->db->createCommand($sql)->execute();
        }
        
        return true;
    }
}
