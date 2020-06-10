<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;


class SpeedrunnerController extends Controller
{
    public function actionDbImport($file)
    {
        $file = Yii::getAlias("@console/db/$file");
        
        if ((is_file($file)) && pathinfo($file)['extension'] == 'sql') {
            if (Console::confirm('Are you sure?')) {
                $this->stdout("Database import started\n", Console::FG_YELLOW);
                
                try {
                    $sql = file_get_contents($file);
                    Yii::$app->db->createCommand($sql)->execute();
                    
                    $this->stdout("Database import finished\n", Console::FG_GREEN);
                } catch (\Exception $e) {
                    throw new \yii\console\Exception($e);
                }
            } else {
                $this->stdout("Database import declined\n", Console::FG_YELLOW);
            }
        } else {
            throw new \yii\console\Exception('File not found');
        }
    }
    
    public function actionDbExport($file)
    {
        $file = Yii::getAlias("@console/db/$file");
        
        if ((!is_file($file))) {
            if (Console::confirm('Are you sure?')) {
                $this->stdout("Database export started\n", Console::FG_YELLOW);
                
                try {
                    $db = Yii::$app->db;
                    $command = 'mysqldump --opt -h' . $this->getDsnAttribute('host', $db->dsn) . ' -u' . $db->username . ' -p' . $db->password . ' ';
                    $command .= $this->getDsnAttribute('dbname', $db->dsn) . ' > ' . $file;
                    exec($command);
                    
                    $this->stdout("Database export finished\n", Console::FG_GREEN);
                } catch (\Exception $e) {
                    throw new \yii\console\Exception($e);
                }
            } else {
                $this->stdout("Database export declined\n", Console::FG_YELLOW);
            }
        } else {
            throw new \yii\console\Exception('This DB file allready exists');
        }
    }
    
    protected function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }
}
