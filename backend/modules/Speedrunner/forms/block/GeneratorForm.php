<?php

namespace backend\modules\Speedrunner\forms\block;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\Block\models\BlockType;
use backend\modules\Block\models\BlockPage;


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
            'blocks' => 'Blocks',
        ];
    }
    
    public function process()
    {
        BlockType::deleteAll();
        BlockPage::deleteAll();
        
        $attrs = ['name', 'label', 'input_type', 'image', 'has_translation'];
        
        foreach ($this->blocks as $b) {
            $block = new BlockType();
            
            foreach ($attrs as $a) {
                $block->{$a} = $b[$a];
            }
            
            $block->attrs = array_values(ArrayHelper::getValue($b, 'attrs', []));
            $block->save();
        }
        
        return true;
    }
}
