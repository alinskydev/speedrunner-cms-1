<?php

namespace backend\modules\SpeedRunner\forms\staticpage;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use backend\modules\StaticPage\models\StaticPage;
use backend\modules\StaticPage\models\StaticPageBlock;


class GeneratorForm extends Model
{
    public $page_name;
    public $has_seo_meta;
    
    public $blocks = [];
    
    public function rules()
    {
        return [
            [['page_name'], 'required'],
            [['page_name'], 'string', 'max' => 100],
            [['has_seo_meta'], 'boolean'],
            [['blocks'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'page_name' => Yii::t('speedrunner', 'Page name'),
            'has_seo_meta' => Yii::t('speedrunner', 'Has SEO meta'),
            'blocks' => Yii::t('speedrunner', 'Blocks'),
        ];
    }
    
    public function generate()
    {
        if ($page = StaticPage::find()->where(['location' => $this->page_name])->one()) {
            $page->delete();
        }
        
        $page = new StaticPage;
        $page->location = $this->page_name;
        $page->has_seo_meta = $this->has_seo_meta;
        
        if ($page->save()) {
            $attrs = ['name', 'label', 'type', 'part_name', 'part_index', 'has_translation'];
            
            foreach ($this->blocks as $b) {
                $block = new StaticPageBlock;
                $block->item_id = $page->id;
                
                foreach ($attrs as $a) {
                    $block->{$a} = $b[$a];
                }
                
                $block->attrs = array_values(ArrayHelper::getValue($b, 'attrs', []));
                $block->save();
            }
        } else {
            return false;
        }
        
        return true;
    }
}
