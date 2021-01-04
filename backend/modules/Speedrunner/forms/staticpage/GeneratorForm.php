<?php

namespace backend\modules\Speedrunner\forms\staticpage;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\Staticpage\models\Staticpage;
use backend\modules\Staticpage\models\StaticpageBlock;


class GeneratorForm extends Model
{
    public $name;
    public $label;
    public $has_seo_meta;
    
    public $blocks = [];
    
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['name', 'label'], 'string', 'max' => 100],
            [['has_seo_meta'], 'boolean'],
            [['blocks'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'label' => 'Label',
            'has_seo_meta' => 'Has SEO meta',
            'blocks' => 'Blocks',
        ];
    }
    
    public function process()
    {
        if ($page = Staticpage::find()->andWhere(['name' => $this->name])->one()) {
            $page->delete();
        }
        
        $page = new Staticpage();
        $page->name = $this->name;
        $page->label = $this->label;
        $page->has_seo_meta = $this->has_seo_meta;
        
        if ($page->save()) {
            $attrs = ['name', 'label', 'type', 'part_name', 'part_index', 'has_translation'];
            
            foreach ($this->blocks as $b) {
                $block = new StaticpageBlock();
                $block->item_id = $page->id;
                
                foreach ($attrs as $a) {
                    $block->{$a} = $b[$a];
                }
                
                $block->attrs = array_values(ArrayHelper::getValue($b, 'attrs', []));
                $block->value = '';
                $block->save();
            }
        } else {
            return false;
        }
        
        return true;
    }
}
