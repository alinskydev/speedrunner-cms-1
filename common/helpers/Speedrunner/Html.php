<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\Html as YiiHtml;
use yii\helpers\ArrayHelper;


class Html
{
    public function updateButtons($buttons)
    {
        $result = [];
        
        foreach ($buttons as $b) {
            switch ($b) {
                case 'save_reload':
                    $result[] = YiiHtml::button(
                        YiiHtml::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & reload'),
                        ['class' => 'btn btn-info btn-icon', 'data-toggle' => 'save-reload']
                    );
                    
                    break;
                case 'save':
                    $result[] = YiiHtml::submitButton(
                        YiiHtml::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                        ['class' => 'btn btn-primary btn-icon']
                    );
                    
                    break;
            }
        }
        
        return YiiHtml::tag('div', implode(' ', $result), ['class' => 'float-right']);
    }
}
