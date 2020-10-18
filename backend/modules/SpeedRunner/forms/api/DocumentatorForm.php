<?php

namespace backend\modules\Speedrunner\forms\api;

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
            [['module'], 'in', 'range' => array_keys($this->modulesList())],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'module' => Yii::t('speedrunner', 'Module'),
        ];
    }
    
    static function modulesList()
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
        
        $module_name = $this->modulesList()[$this->module];
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
                    
                    $link = array_merge(["$module->id/$controller_url/$a_key"], array_combine($params['get'], $params['get']));
                    $url = Yii::$app->urlManagerApi->createFileUrl($link);
                    
                    //        POST PARAMS
                    
                    $params['post'] = [];
                    $properties = $controller_reflection->getDefaultProperties();
                    
                    if (isset($properties['forms'][$a_key])) {
                        $form = new $properties['forms'][$a_key];
                        
                        foreach ($form->rules() as $rule) {
                            foreach ($rule[0] as $r) {
                                $rule_tmp = $rule;
                                $rule_string = $rule_tmp[1];
                                
                                unset($rule_tmp[0], $rule_tmp[1]);
                                
                                array_walk($rule_tmp, function(&$value, $key) {
                                    if (is_callable($value)) {
                                        $value = "$key: FUNCTION";
                                    } elseif (is_array($value)) {
                                        $value = "$key: [" . $this->implodeRecursive(', ', $value) . ']';
                                    } else {
                                        $value = "$key: $value";
                                    }
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
        
        $folder_template = Yii::getAlias('@backend/modules/Speedrunner/templates/api/documentator');
        $folder_template_render = '@backend/modules/Speedrunner/templates/api/documentator/';
        $file_content = Yii::$app->controller->renderPartial("$folder_template_render/index.php", ['result' => $result]);
        
        //        ZIP ARCHIVE
        
        $file = tempnam(sys_get_temp_dir(), 'zip');
        $zip = new \ZipArchive();
        $zip->open($file, \ZipArchive::OVERWRITE);
        
        $zip->addFromString('api.html', $file_content);
        $zip->addFile("$folder_template/assets/css/bootstrap.min.css", 'assets/css/bootstrap.min.css');
        $zip->addFile("$folder_template/assets/css/speedrunner.css", 'assets/css/speedrunner.css');
        
        $zip->addFile("$folder_template/assets/fonts/Oswald/ExtraLight.ttf", 'assets/fonts/Oswald/ExtraLight.ttf');
        $zip->addFile("$folder_template/assets/fonts/Oswald/Light.ttf", 'assets/fonts/Oswald/Light.ttf');
        $zip->addFile("$folder_template/assets/fonts/Oswald/Regular.ttf", 'assets/fonts/Oswald/Regular.ttf');
        $zip->addFile("$folder_template/assets/fonts/Oswald/Medium.ttf", 'assets/fonts/Oswald/Medium.ttf');
        $zip->addFile("$folder_template/assets/fonts/Oswald/SemiBold.ttf", 'assets/fonts/Oswald/SemiBold.ttf');
        $zip->addFile("$folder_template/assets/fonts/Oswald/Bold.ttf", 'assets/fonts/Oswald/Bold.ttf');
        
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
    
    protected function implodeRecursive($separator, $arrayvar)
    {
        $output = null;
        
        foreach ($arrayvar as $key => $av) {
            $output .= (!is_int($key) ? "$key: " : null);
            
            if (is_array($av)) {
                $output .= $this->implodeRecursive($separator, $av);
            } else {
                $output .= $separator . $av;
            }
        }

        return trim($output, $separator);
    }
}
