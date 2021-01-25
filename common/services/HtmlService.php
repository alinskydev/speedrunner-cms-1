<?php

namespace common\services;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class HtmlService
{
    public function updateButtons($buttons_list)
    {
        foreach ($buttons_list as $button) {
            switch ($button) {
                case 'save_reload':
                    $result[] = Html::button(
                        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & reload'),
                        ['class' => 'btn btn-info btn-icon', 'data-toggle' => 'save-reload']
                    );
                    
                    break;
                case 'save':
                    $result[] = Html::submitButton(
                        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                        ['class' => 'btn btn-primary btn-icon']
                    );
                    
                    break;
            }
        }
        
        return Html::tag('div', implode(' ', $result ?? []), ['class' => 'float-right']);
    }
}
