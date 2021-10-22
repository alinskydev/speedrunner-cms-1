<?php

namespace console\controllers\speedrunner;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;


class InstallController extends Controller
{
    public function actionIndex()
    {
        $db_params = ['name', 'username', 'password'];
        
        foreach ($db_params as $param) {
            $this->stdout("Enter DB $param: ");
            $db_config[$param] = Console::input();
        }
        
        echo '<pre>';
        print_r($db_config);
        echo '</pre>';
        die;
        
        $dir = Yii::getAlias('@console/templates/install');
        
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
}
