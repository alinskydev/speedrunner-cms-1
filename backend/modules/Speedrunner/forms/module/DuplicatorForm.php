<?php

namespace backend\modules\Speedrunner\forms\module;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;


class DuplicatorForm extends Model
{
    public $duplicate_types = ['files', 'db_tables'];
    
    public $module_name_from;
    public $module_name_to;
    
    public function rules()
    {
        return [
            [['duplicate_types', 'module_name_from', 'module_name_to'], 'required'],
            [['duplicate_types'], 'in', 'range' => array_keys($this->duplicateTypes()), 'allowArray' => true],
            [['module_name_from'], 'in', 'range' => array_keys($this->modulesList())],
            [['module_name_to'], 'in', 'range' => array_keys($this->modulesList()), 'not' => true],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'duplicate_types' => 'Duplicate types',
            'module_name_from' => 'Module name (from)',
            'module_name_to' => 'Module name (to)',
        ];
    }
    
    public static function duplicateTypes()
    {
        return [
            'files' => 'Files',
            'db_tables' => 'DB tables',
        ];
    }
    
    public static function modulesList()
    {
        foreach (Yii::$app->modules as $key => $m) {
            if (!in_array($key, ['debug', 'gii', 'speedrunner'])) {
                $result[ucfirst($key)] = ucfirst($key);
            }
        }
        
        return $result ?? [];
    }
    
    public function process()
    {
        //        Files
        
        if (in_array('files', $this->duplicate_types)) {
            $name_from = Yii::getAlias("@backend/modules/$this->module_name_from");
            $name_to = Yii::getAlias("@backend/modules/$this->module_name_to");
            
            $replace_arr_from = [$this->module_name_from, strtolower($this->module_name_from)];
            $replace_arr_to = [$this->module_name_to, strtolower($this->module_name_to)];
            
            FileHelper::createDirectory($name_to);
            
            $folders = FileHelper::findDirectories($name_from);
            $files = FileHelper::findFiles($name_from);
            $folders_files = ArrayHelper::merge($folders, $files);
            
            foreach ($folders_files as $f_f) {
                $f_f_new = str_replace($replace_arr_from, $replace_arr_to, $f_f);
                
                if (is_file($f_f)) {
                    copy($f_f, $f_f_new);
                    
                    $file_old_content = file_get_contents($f_f_new);
                    $file_new_content = str_replace($replace_arr_from, $replace_arr_to, $file_old_content);
                    
                    $file_new = fopen($f_f_new, 'w');
                    fwrite($file_new, $file_new_content);
                    fclose($file_new);
                } else {
                    FileHelper::createDirectory($f_f_new);
                }
            }
        }
        
        //        DB
        
        if (in_array('db_tables', $this->duplicate_types)) {
            $tables = Yii::$app->db->schema->getTableNames();
            $sql = [];
            
            foreach ($tables as $t) {
                if (strpos($t, $this->module_name_from) === 0) {
                    $new_table_name = str_replace($this->module_name_from, $this->module_name_to, $t);
                    $sql[] = "CREATE TABLE $new_table_name LIKE $t";
                }
            }
            
            Yii::$app->db->createCommand(implode(';', $sql))->execute();
        }
        
        return true;
    }
}
