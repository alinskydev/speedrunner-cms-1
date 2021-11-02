<?php

namespace backend\modules\Speedrunner\forms\module;

use Yii;
use speedrunner\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\db\Schema;
use yii\helpers\Inflector;


class GeneratorForm extends Model
{
    public $module_name;
    public $generate_files = ['module', 'controller', 'models', 'search', 'views'];
    
    public $controller_name;
    public $controller_actions = ['index', 'create', 'update', 'delete'];
    
    public $table_name;
    public $model_name;
    public $has_seo_meta;
    
    public $model_relations = [];
    public $view_relations = [];
    
    public $attrs_fields = [];
    public $attrs_translation = [];
    
    public function prepareRules()
    {
        return [
            'module_name' => [
                ['required'],
                ['in', 'range' => $this->modulesList(), 'not' => true, 'when' => fn($model) => in_array('module', $this->generate_files)],
            ],
            'generate_files' => [
                ['required'],
            ],
            'controller_name' => [
                ['required'],
            ],
            'controller_actions' => [
                ['required'],
                ['in', 'allowArray' => true, 'range' => $this->getControllerActions()],
            ],
            'table_name' => [
                ['required'],
            ],
            'has_seo_meta' => [
                ['boolean'],
            ],
            'model_relations' => [
                ['safe'],
            ],
            'view_relations' => [
                ['safe'],
            ],
            'attrs_fields' => [
                ['safe'],
            ],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'module_name' => 'Module name',
            'generate_files' => 'Generate files',
            'controller_name' => 'Controller name',
            'controller_actions' => 'Controller actions',
            'table_name' => 'Table name',
            'has_seo_meta' => 'Has SEO meta',
            'model_relations' => 'Model relations',
            'view_relations' => 'View relations',
            'attrs_fields' => 'Attributes fields',
        ];
    }
    
    public function getGenerateFiles()
    {
        $result = ['module', 'controller', 'models', 'search', 'views'];
        return array_combine($result, $result);
    }
    
    public function getControllerActions()
    {
        $result = ['index', 'view', 'create', 'update', 'delete'];
        return array_combine($result, $result);
    }
    
    public static function modulesList()
    {
        foreach (Yii::$app->modules as $key => $m) {
            $result[ucfirst($key)] = ucfirst($key);
        }
        
        return $result ?? [];
    }
    
    public function afterValidate()
    {
        $this->model_name = Inflector::id2camel($this->table_name, '_');
        return parent::afterValidate();
    }
    
    public function process()
    {
        //        Prepare
        
        $folder_template = Yii::getAlias('@backend/modules/Speedrunner/templates/module/generator');
        $folder_template_render = '@backend/modules/Speedrunner/templates/module/generator';
        $folder_module = Yii::getAlias("@backend/modules/$this->module_name/");
        
        FileHelper::createDirectory($folder_module, $mode = 0644);
        
        $this->attrs_translation = array_filter($this->attrs_fields, fn($value) => ArrayHelper::getValue($value, 'has_translation')) ?: [];
        
        //        Module
        
        if (in_array('module', $this->generate_files)) {
            $file_content = Yii::$app->controller->renderPartial("$folder_template_render/Module.php", ['model' => $this]);
            $file = fopen($folder_module . 'Module.php', 'w');
            fwrite($file, $file_content);
            fclose($file);
        }
        
        //        Controller
        
        if (in_array('controller', $this->generate_files)) {
            $dir = $folder_module . 'controllers/';
            FileHelper::createDirectory($dir, $mode = 0644);
            
            $file_content = Yii::$app->controller->renderPartial("$folder_template_render/controllers/Controller.php", ['model' => $this]);
            $file = fopen($dir . $this->controller_name . 'Controller.php', 'w');
            fwrite($file, $file_content);
            fclose($file);
        }
        
        //        Models
        
        if (in_array('models', $this->generate_files)) {
            
            //        Self
            
            $dir = $folder_module . 'models/';
            FileHelper::createDirectory($dir, $mode = 0644);
            
            $file_content = Yii::$app->controller->renderPartial("$folder_template_render/models/Model.php", ['model' => $this]);
            $file = fopen($dir . $this->model_name . '.php', 'w');
            fwrite($file, $file_content);
            fclose($file);
        }
        
        //        Search models
        
        if (in_array('search', $this->generate_files)) {
            $dir = $folder_module . 'search/';
            FileHelper::createDirectory($dir, $mode = 0644);
            
            $file_content = Yii::$app->controller->renderPartial("$folder_template_render/search/Model.php", ['model' => $this]);
            $file = fopen($dir . $this->model_name . 'Search.php', 'w');
            fwrite($file, $file_content);
            fclose($file);
        }
        
        //        Views
        
        if (in_array('views', $this->generate_files)) {
            $dir = $folder_module . 'views/';
            FileHelper::createDirectory($dir, $mode = 0644);
            $view_files = [];
            
            if (in_array('index', $this->controller_actions)) {
                $view_files[] = 'index';
            }
            
            if (in_array('view', $this->controller_actions)) {
                $view_files[] = 'view';
            }
            
            if (in_array('create', $this->controller_actions) || in_array('update', $this->controller_actions)) {
                $view_files[] = 'update';
            }
            
            foreach ($view_files as $v_f) {
                $dir = $folder_module . 'views/' . Inflector::camel2id($this->controller_name) . '/';
                FileHelper::createDirectory($dir, $mode = 0644);
                
                $file_content = Yii::$app->controller->renderPartial("$folder_template_render/views/$v_f.php", ['model' => $this]);
                $file = fopen($dir . $v_f . '.php', 'w');
                fwrite($file, $file_content);
                fclose($file);
            }
            
            //        View relations
            
            foreach ($this->view_relations as $r) {
                $dir = $folder_module . 'views/' . mb_strtolower($this->controller_name) . '/';
                FileHelper::createDirectory($dir, $mode = 0644);
                
                $file_content = Yii::$app->controller->renderPartial("$folder_template_render/views/_relations.php", [
                    'model' => $this,
                    'relation' => $r
                ]);
                
                $file = fopen($dir . '_' . str_replace('_tmp', null, $r['var_name']) . '.php', 'w');
                fwrite($file, $file_content);
                fclose($file);
            }
        }
        
        return true;
    }
    
    public function generateRules($columns)
    {
        $attributes = [];
        $rules = [];
        
        foreach ($columns as $column) {
            if ($column->autoIncrement || in_array($column->name, ['created_at', 'updated_at'])) {
                continue;
            }
            
            if ($column->name == 'slug') {
                $attributes[$column->name][] = ['SlugValidator::className()'];
                continue;
            }
            
            if (!$column->allowNull && $column->defaultValue === null && !in_array($column->type, ['date', 'time', 'datetime'])) {
                $attributes[$column->name][] = ["'required'"];
            }
            
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $attributes[$column->name][] = ["'integer'"];
                    break;
                case Schema::TYPE_TINYINT:
                    if ($column->size == 1) {
                        $attributes[$column->name][] = ["'boolean'"];
                    } else {
                        $attributes[$column->name][] = ["'integer'"];
                    }
                    break;
                case Schema::TYPE_BOOLEAN:
                    $attributes[$column->name][] = ["'boolean'"];
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $attributes[$column->name][] = ["'number'"];
                    break;
                case Schema::TYPE_DATE:
                    $attributes[$column->name][] = ["'date'", "'format'" => "'php: d.m.Y'"];
                    break;
                case Schema::TYPE_TIME:
                    $attributes[$column->name][] = ["'date'", "'format'" => "'php: H:i'"];
                    break;
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $attributes[$column->name][] = ["'date'", "'format'" => "'php: d.m.Y H:i'"];
                    break;
                case Schema::TYPE_JSON:
                    if (in_array($column->name, array_keys($this->attrs_translation))) {
                        $attributes[$column->name][] = ["'string'"];
                    } else {
                        $attributes[$column->name][] = ["'safe'"];
                    }
                    break;
                default:
                    if ($column->size > 0) {
                        $attributes[$column->name][] = ["'string'", "'max'" => $column->size];
                    } else {
                        $attributes[$column->name][] = ["'string'"];
                    }
            }
        }
        
        foreach ($attributes as $attribute => &$rules) {
            foreach ($rules as $rule_index => &$rule) {
                foreach ($rule as $key => $r) {
                    if ($key) {
                        $rule[] = "$key => $r";
                    } else {
                        $rule[] = $r;
                    }
                    
                    unset($rule[$key]);
                }
                
                $rule = implode(', ', $rule);
            }
            
            $result[$attribute] = "'$attribute' => [";
            $result[$attribute] .= "\n                [" . implode("],\n                [", $rules) . "],\n";
            $result[$attribute] .= "            ],\n";
        }
        
        return implode("            ", $result ?? []);
    }
    
    public function generateSearchRules($columns)
    {
        $types = [];
        $rules = [];
        
        foreach ($columns as $column) {
            switch ($column->type) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_TEXT:
                    break;
                default:
                    $types['safe'][] = $column->name;
                    break;
            }
        }
        
        foreach ($types as $type => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }
        
        return $rules;
    }
    
    public function generateSearchConditions($columns)
    {
        $columns = ArrayHelper::map($columns, 'name', 'type');
        $attrs_translation = array_keys($this->attrs_translation);
        $condition_groups = [];
        
        foreach ($columns as $column => $type) {
            switch ($type) {
                case Schema::TYPE_TINYINT:
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_TIME:
                case Schema::TYPE_TIMESTAMP:
                    $condition_groups['='][] = $column;
                    break;
                case Schema::TYPE_TEXT:
                case Schema::TYPE_JSON:
                    break;
                default:
                    $condition_groups['like'][] = $column;
                    break;
            }
        }
        
        $filter[] = "\$attribute_groups = [";
        
        foreach ($condition_groups as $group_name => $conditions) {
            $conditions = implode("', '", $conditions);
            $filter[] = "    '$group_name' => ['$conditions'],";
        }
        
        $filter[] = "];\n";
        return $filter;
    }
}
