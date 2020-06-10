<?php

namespace backend\modules\SpeedRunner\forms\block;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\Block\models\BlockType;


class GeneratorForm extends Model
{
    public $blocks = [];
    
    public function rules()
    {
        return [
            [['blocks'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'blocks' => Yii::t('speedrunner', 'Blocks'),
        ];
    }
    
    public function generate()
    {
        $types = BlockType::find()->all();
        foreach ($types as $t) { $t->delete(); };
        
        $attrs = ['name', 'label', 'type', 'image', 'has_translation'];
        
        foreach ($this->blocks as $b) {
            $block = new BlockType;
            
            foreach ($attrs as $a) {
                $block->{$a} = $b[$a];
            }
            
            $block->attrs = isset($b['attrs']) ? json_encode($b['attrs'], JSON_UNESCAPED_UNICODE) : null;
            $block->save();
        }
        
        return true;
    }
}
