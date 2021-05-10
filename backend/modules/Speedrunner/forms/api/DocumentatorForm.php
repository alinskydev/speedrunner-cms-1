<?php

namespace backend\modules\Speedrunner\forms\api;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;


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
            'module' => 'Module',
        ];
    }
    
    public static function modulesList()
    {
        $config = require(Yii::getAlias('@api/config/main.php'));
        
        foreach ($config['modules'] as $key => $m) {
            $result[$m['class']] = $key;
        }
        
        return $result ?? [];
    }
    
    public function process()
    {
        //        Module
        
        $module_name = $this->modulesList()[$this->module];
        $module = new $this->module($module_name);
        $controller_files = FileHelper::findFiles($module->controllerPath);
        
        foreach ($controller_files as $file) {
            
            //        Controller
            
            $controller_basename = StringHelper::basename($file);
            $controller_name = str_replace(['Controller', '.php'], null, $controller_basename);
            $controller_url = Inflector::camel2id($controller_name, '-');
            
            $controller_class = str_replace(['.php'], null, $controller_basename);
            $controller_class = "$module->controllerNamespace\\$controller_class";
            
            $controller_reflection = new \ReflectionClass($controller_class);
            $controller = new $controller_class($controller_class, $module);
            $methods = ArrayHelper::index($controller_reflection->getMethods(), 'name');
            
            if ($form_method_reflection = ArrayHelper::getValue($methods, 'actions')) {
                foreach ($form_method_reflection->invoke($controller) as $action_key => $action) {
                    if ($action['class'] == 'speedrunner\actions\rest\FormAction') {
                        $forms[$action_key] = $action['model'] ?? new $action['model_class'];
                    }
                }
            }
            
            if ($controller_comment = $controller_reflection->getDocComment()) {
                $controller_comment = explode(PHP_EOL, $controller_comment);
                array_shift($controller_comment);
                array_pop($controller_comment);
                $controller_comment = implode(PHP_EOL, $controller_comment);
                
                $result[$controller_name]['comment'] = str_replace('* ', null, $controller_comment);
            }
            
            if (isset($controller->behaviors['authenticator'])) {
                $result[$controller_name]['behaviors'][] = 'Need authentication';
            }
            
            if (isset($controller->behaviors['verbs']->actions)) {
                $actions = $controller->behaviors['verbs']->actions;
                
                foreach ($actions as $a_key => $a) {
                    $params = ['get' => [], 'post' => []];
                    
                    //        GET params
                    
                    $method_name = 'action' . Inflector::id2camel($a_key, '-');
                    
                    if ($method_reflection = ArrayHelper::getValue($methods, $method_name)) {
                        $params['get'] = $method_reflection->getParameters();
                        $params['get'] = ArrayHelper::getColumn($params['get'], 'name');
                    }
                    
                    $get_param_values = array_map(fn ($value) => "{{$value}}", $params['get']);
                    $link = array_merge(["$module->id/$controller_url/$a_key"], array_combine($params['get'], $get_param_values));
                    $url = Yii::$app->urlManagerApi->createFileUrl($link);
                    
                    //        POST params
                    
                    if ($form = ArrayHelper::getValue($forms ?? [], $a_key)) {
                        foreach ($form->rules() as $rule) {
                            foreach ($rule[0] as $r) {
                                $rule_tmp = $rule;
                                $rule_string = $rule_tmp[1];
                                
                                unset($rule_tmp[0], $rule_tmp[1]);
                                
                                array_walk($rule_tmp, function(&$value, $key) {
                                    if (is_callable($value)) {
                                        $value = "$key: FUNCTION";
                                    } elseif (is_array($value)) {
                                        $value = "$key: [" . self::implodeRecursive(', ', $value) . ']';
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
        $file_content = Yii::$app->controller->renderPartial("$folder_template_render/index.php", ['result' => $result ?? []]);
        
        //        ZIP archive
        
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
        
        $file_name = Yii::$app->services->settings->site_name . ' API.zip';
        header('Content-Type: application/zip');
        header("Content-Disposition: attachment; filename=$file_name");
        readfile($file);
        unlink($file);
        
        die;
    }
    
    private static function implodeRecursive($separator, $arrayvar)
    {
        $output = null;
        
        foreach ($arrayvar as $key => $av) {
            $output .= (!is_int($key) ? "$key: " : null);
            
            if (is_array($av)) {
                $output .= self::implodeRecursive($separator, $av);
            } else {
                $output .= $separator . $av;
            }
        }

        return trim($output, $separator);
    }
}
