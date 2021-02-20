<?php

namespace speedrunner\services;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;


class HtmlService
{
    public static function saveButtons($buttons_list)
    {
        foreach ($buttons_list as $button) {
            switch ($button) {
                case 'save_update':
                    $result[] = Html::button(
                        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & update'),
                        ['class' => 'btn btn-info btn-icon', 'data-toggle' => 'save-and-update']
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
    
    public static function dump($var, $depth = 10, $highlight = true)
    {
        return VarDumper::dump($var, $depth, $highlight);
    }
}
