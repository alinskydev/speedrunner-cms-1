<?php

namespace wokster\treebehavior;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\db\Expression;


class NestedSetsTreeBehavior extends Behavior
{
    /**
     * @var string
     */
    public $leftAttribute = 'lft';
    /**
     * @var string
     */
    public $rightAttribute = 'rgt';
    /**
     * @var string
     */
    public $depthAttribute = 'depth';
    /**
     * @var string
     */
    public $labelAttribute = 'name';
    /**
     * @var string
     */
    public $childrenOutAttribute = 'children';
    /**
     * @var string
     */
    public $labelOutAttribute = 'title';
    /**
     * @var string
     */
    public $hasChildrenOutAttribute = 'folder';
    /**
     * @var null|callable
     */
    public $makeLinkCallable = null;
    /**
     * @var array
     */
    
    public $isAttributeTranslatable = false;

    public function tree()
    {
        // Trees mapped
        $lang = \Yii::$app->language;
        $trees = [];
        
        $query = $this->owner->children()
            ->select([
                '*',
            ]);
        
        if ($this->isAttributeTranslatable) {
            $query->addSelect([new Expression("$this->labelAttribute->>'$.$lang' as $this->labelOutAttribute")]);
        } else {
            $query->addSelect("$this->labelAttribute as $this->labelOutAttribute");
        }
        
        if ($collection = $query->asObject()->all()) {
            $expanded_list = ArrayHelper::getValue(Yii::$app->session->get('expanded'), StringHelper::baseName($this->owner::className()), []);
            
            foreach ($collection as &$col) {
                $col->expanded = in_array($col->id, $expanded_list);
            }

            // Node Stack. Used to help building the hierarchy
            $stack = [];
            
            foreach ($collection as $node) {
                $item = $node;
                $item->{$this->childrenOutAttribute} = [];

                // Number of stack items
                $l = count($stack);

                // Check if we're dealing with different levels
                while ($l > 0 && $stack[$l - 1]->{$this->rightAttribute} < $item->{$this->rightAttribute}) {
                    array_pop($stack);
                    $l--;
                }

                // Stack is empty (we are inspecting the root)
                if ($l == 0) {
                    // Assigning the root node
                    $i = count($trees);
                    $trees[$i] = $item;
                    $stack[] = &$trees[$i];
                } else {
                    // Add node to parent
                    $i = count($stack[$l - 1]->{$this->childrenOutAttribute});
                    $stack[$l - 1]->{$this->hasChildrenOutAttribute} = true;
                    $stack[$l - 1]->{$this->childrenOutAttribute}[$i] = $item;
                    $stack[] = &$stack[$l - 1]->{$this->childrenOutAttribute}[$i];
                }
            }
        }
        
        return $trees;
    }
}