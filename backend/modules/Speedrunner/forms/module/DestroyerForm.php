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
            'modules' => 'Modules',
        ];
    }
    
    public static function modulesList()
    {
        foreach (Yii::$app->modules as $key => $m) {
            if (!in_array($key, ['debug', 'gii', 'seo', 'speedrunner', 'staticpage', 'system', 'translation', 'user'])) {
                $result[ucfirst($key)] = ucfirst($key);
            }
        }
        
        return $result ?? [];
    }
    
    public function process()
    {
        foreach ($this->modules as $m) {
            
            //        Files
            
            $dir = Yii::getAlias("@backend/modules/$m");
            
            if (is_dir($dir)) {
                FileHelper::removeDirectory($dir);
            }
            
            //        DB
            
            $tables = Yii::$app->db->schema->getTableNames();
            $table_prefix = strtolower($m);
            $sql[] = 'SET FOREIGN_KEY_CHECKS = 0';
            
            foreach ($tables as $t) {
                if (strpos($t, $table_prefix) === 0) {
                    $sql[] = "DROP TABLE `$t`";
                }
            }
            
            $sql[] = 'SET FOREIGN_KEY_CHECKS = 1';
        }
        
        Yii::$app->db->createCommand(implode(';', $sql))->execute();
        
        return true;
    }
}
