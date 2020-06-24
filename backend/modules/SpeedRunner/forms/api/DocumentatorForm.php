<?php

namespace backend\modules\SpeedRunner\forms\api;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

use backend\modules\Block\models\BlockType;


class DocumentatorForm extends Model
{
    public $module;
    
    public function rules()
    {
        return [
            [['module'], 'required'],
            [['module'], 'in', 'range' => array_keys($this->modulesList)],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'module' => Yii::t('speedrunner', 'Module'),
        ];
    }
    
    static function getModulesList()
    {
        $config = require(Yii::getAlias('@api/config/main.php'));
        
        foreach ($config['modules'] as $key => $m) {
            $result[$m['class']] = $key;
        }
        
        return $result;
    }
    
    public function process()
    {
        $result = [];
        
        //        MODULE
        
        $module_name = $this->modulesList[$this->module];
        $module = new $this->module($module_name);
        $controller_files = FileHelper::findFiles($module->controllerPath);
        
        foreach ($controller_files as $file) {
            
            //        CONTROLLER
            
            $controller_basename = StringHelper::basename($file);
            $controller_name = str_replace(['Controller', '.php'], null, $controller_basename);
            $controller_url = Inflector::camel2id($controller_name, '-');
            
            $controller_class = str_replace(['.php'], null, $controller_basename);
            $controller_class = "$module->controllerNamespace\\$controller_class";
            
            $controller_reflection = new \ReflectionClass($controller_class);
            $controller = new $controller_class($controller_class, $module);
            
            $result[$controller_name]['behaviors'] = [];
            
            if (isset($controller->behaviors['authenticator'])) {
                $result[$controller_name]['behaviors'][] = 'Need authentication';
            }
            
            if (isset($controller->behaviors['verbs']->actions)) {
                $actions = $controller->behaviors['verbs']->actions;
                
                foreach ($actions as $a_key => $a) {
                    
                    //        GET PARAMS
                    
                    $method_name = 'action' . Inflector::id2camel($a_key, '-');
                    $params['get'] = $controller_reflection->getMethod($method_name)->getParameters();
                    $params['get'] = ArrayHelper::getColumn($params['get'], 'name');
                    
                    if ($a_key == 'index') {
                        $url = Yii::$app->urlManagerApi->createFileUrl(["$module->id/$controller_url"]);
                    } elseif (in_array('id', $params['get'])) {
                        $url = Yii::$app->urlManagerApi->createFileUrl(["$module->id/$controller_url/$a_key", 'id' => '{id}']);
                    } else {
                        $url = Yii::$app->urlManagerApi->createFileUrl(["$module->id/$controller_url/$a_key"]);
                    }
                    
                    //        POST PARAMS
                    
                    $params['post'] = [];
                    $static_properties = $controller_reflection->getStaticProperties();
                    
                    if (isset($static_properties['forms'][$a_key])) {
                        $form = $static_properties['forms'][$a_key];
                        $form = new $form;
                        
                        foreach ($form->rules() as $rule) {
                            foreach ($rule[0] as $r) {
                                $rule_tmp = $rule;
                                $rule_string = $rule_tmp[1];
                                
                                unset($rule_tmp[0], $rule_tmp[1]);
                                
                                array_walk($rule_tmp, function(&$value, $key) {
                                    $value = "$key: $value";
                                });
                                
                                $rule_string .= $rule_tmp ? ' (' . implode(', ', $rule_tmp) . ')' : null;
                                $params['post'][$r][] = $rule_string;
                            }
                        }
                    }
                    
                    $result[$controller_name]['actions'][] = [
                        'url' => rawurldecode($url),
                        'methods' => $a,
                        'params' => $params,
                    ];
                }
            }
        }
        
        $folder_template = Yii::getAlias('@backend/modules/SpeedRunner/templates/api/documentator');
        $folder_template_render = '@backend/modules/SpeedRunner/templates/api/documentator/';
        $file_content = Yii::$app->controller->renderPartial("$folder_template_render/index.php", ['result' => $result]);
        
        //        ZIP ARCHIVE
        
        $file = tempnam("tmp", "zip");
        $zip = new \ZipArchive();
        $zip->open($file, \ZipArchive::OVERWRITE);
        
        $zip->addFromString('api.html', $file_content);
        $zip->addFile("$folder_template/assets/css/bootstrap.min.css", 'assets/css/bootstrap.min.css');
        $zip->addFile("$folder_template/assets/css/speedrunner.css", 'assets/css/speedrunner.css');
        
        $zip->addFile("$folder_template/assets/fonts/Exo2/Thin.ttf", 'assets/fonts/Exo2/Thin.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/ExtraLight.ttf", 'assets/fonts/Exo2/ExtraLight.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/Light.ttf", 'assets/fonts/Exo2/Light.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/Regular.ttf", 'assets/fonts/Exo2/Regular.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/Medium.ttf", 'assets/fonts/Exo2/Medium.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/SemiBold.ttf", 'assets/fonts/Exo2/SemiBold.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/Bold.ttf", 'assets/fonts/Exo2/Bold.ttf');
        $zip->addFile("$folder_template/assets/fonts/Exo2/ExtraBold.ttf", 'assets/fonts/Exo2/ExtraBold.ttf');
        
        $zip->addFile("$folder_template/assets/js/jquery.js", 'assets/js/jquery.js');
        $zip->addFile("$folder_template/assets/js/popper.min.js", 'assets/js/popper.min.js');
        $zip->addFile("$folder_template/assets/js/bootstrap.min.js", 'assets/js/bootstrap.min.js');
        
        $zip->close();
        
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="api.zip"');
        readfile($file);
        unlink($file); 
        die;
        
        return true;
    }
}
