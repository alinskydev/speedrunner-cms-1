<?php

namespace backend\modules\Speedrunner\forms\module;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\db\Schema;
use yii\helpers\Inflector;


class GeneratorForm extends Model
{
    public $module_name;
    public $generate_files = ['module', 'controller', 'models', 'modelsSearch', 'views'];
    
    public $controller_name;
    public $controller_actions = ['index', 'create', 'update', 'delete'];
    
    public $table_name;
    public $has_seo_meta;
    public $model_relations = [];
    public $view_relations = [];
    
    public $attrs_fields = [];
    public $attrs_translation;
    
    public function rules()
    {
        return [
            [['module_name', 'generate_files', 'controller_name', 'controller_actions', 'table_name'], 'required'],
            [['has_seo_meta'], 'boolean'],
            [['model_relations', 'view_relations', 'attrs_fields'], 'safe'],
            [['module_name'], 'in', 'range' => $this->modulesList(), 'not' => true, 'when' => fn ($model) => in_array('module', $this->generate_files)],
            [['controller_actions'], 'in', 'allowArray' => true, 'range' => $this->getControllerActions()],
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
        $result = ['module', 'controller', 'models', 'modelsSearch', 'views'];
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
    
    public function process()
    {
        //        Prepare
        
        $folder_template = Yii::getAlias('@backend/modules/Speedrunner/templates/module/generator');
        $folder_template_render = '@backend/modules/Speedrunner/templates/module/generator';
        $folder_module = Yii::getAlias("@backend/modules/$this->module_name/");
        
        FileHelper::createDirectory($folder_module, $mode = 0644);
        
        $this->attrs_translation = array_filter($this->attrs_fields, fn ($value) => ArrayHelper::getValue($value, 'has_translation')) ?: [];
        
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
            
            $file_content = Yii::$app->controller->renderPartial("$folder_template_render/controllers/controller.php", ['model' => $this]);
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
            $file = fopen($dir . $this->table_name . '.php', 'w');
            fwrite($file, $file_content);
            fclose($file);
        }
        
        //        Search models
        
        if (in_array('modelsSearch', $this->generate_files)) {
            $dir = $folder_module . 'modelsSearch/';
            FileHelper::createDirectory($dir, $mode = 0644);
            
            $file_content = Yii::$app->controller->renderPartial("$folder_template_render/modelsSearch/Model.php", ['model' => $this]);
            $file = fopen($dir . $this->table_name . 'Search.php', 'w');
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
                $dir = $folder_module . 'views/' . strtolower($this->controller_name) . '/';
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
        $types = [];
        $lengths = [];
        $rules = [];
        
        foreach ($columns as $column) {
            if ($column->autoIncrement || in_array($column->name, ['created', 'updated'])) {
                continue;
            }
            
            if (!$column->allowNull && $column->defaultValue === null && !in_array($column->type, ['date', 'time', 'datetime'])) {
                $types['required'][] = $column->name;
            }
            
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_TINYINT:
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
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $types['safe'][] = $column->name;
                    break;
                case Schema::TYPE_JSON:
                    if (in_array($column->name, array_keys($this->attrs_translation))) {
                        $types['string'][] = $column->name;
                    } else {
                        $types['safe'][] = $column->name;
                    }
                    break;
                default: // strings
                    if ($column->size > 0) {
                        $lengths[$column->size][] = $column->name;
                    } else {
                        $types['string'][] = $column->name;
                    }
            }
        }
        
        foreach ($types as $type => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }
        
        foreach ($lengths as $length => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], 'string', 'max' => $length]";
        }
        
        return $rules;
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
        $conditions = [];
        $likeConditions = [];
        $hashConditions = [];
        
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
                    $hashConditions[] = "'{$column}' => \$this->{$column},";
                    break;
                case Schema::TYPE_TEXT:
                case Schema::TYPE_JSON:
                    break;
                default:
                    $likeKeyword = 'like';
                    $likeConditions[] = "->andFilterWhere(['{$likeKeyword}', '{$column}', \$this->{$column}])";
                    break;
            }
        }
        
        if (!empty($hashConditions)) {
            $conditions[] = "\$query->andFilterWhere([\n"
                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                . "\n" . str_repeat(' ', 8) . "]);\n";
        }
        
        if (!empty($likeConditions)) {
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
        }
        
        return $conditions;
    }
}
