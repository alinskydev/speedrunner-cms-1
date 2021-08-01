<?php

namespace speedrunner\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;


class HtmlHelper
{
    public static function allowedLink($text, $url = null, $options = [])
    {
        if ($url !== null) {
            $role = ArrayHelper::getValue(Yii::$app->user->identity, 'role');
            
            if (!$role || !$role->service->isAllowedByRoute(Yii::$app->urlManager->getRoute($url))) {
                return null;
            }
        }
        
        return Html::a($text, $url, $options);
    }
    
    public static function dump($var, $die = false, $depth = 10, $highlight = true)
    {
        if (in_array(Yii::$app->request->userIP, Yii::$app->params['debug_ips'])) {
            echo VarDumper::dump($var, $depth, $highlight);
            $die ? die : null;
        }
    }
    
    public static function purify($value, $allowed_chars = [])
    {
        $config = \HTMLPurifier_HTML5Config::create([
            'HTML.SafeIframe' => true,
        ]);
        
        $purifier = new \HTMLPurifier($config);
        $value = $purifier->purify($value);
        
        foreach ($allowed_chars as $from => $to) {
            $value = str_replace($from, $to, $value);
        }
        
        return $value;
    }
    
    public static function saveButtons(array $buttons_list, $form_action = null)
    {
        $form_action = $form_action ?? Url::to();
        
        foreach ($buttons_list as $key => $button) {
            switch ($button) {
                case 'save_create':
                    parse_str(parse_url($form_action, PHP_URL_QUERY), $form_action_query);
                    $form_action_query['save_and_create'] = true;
                    $form_action_query = http_build_query($form_action_query);
                    
                    $result[] = Html::submitButton(
                        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & create'),
                        [
                            'class' => 'btn btn-info btn-icon',
                            'formaction' => parse_url($form_action, PHP_URL_PATH) . ($form_action_query ? "?$form_action_query" : null),
                        ]
                    );
                    
                    break;
                case 'save_update':
                    parse_str(parse_url($form_action, PHP_URL_QUERY), $form_action_query);
                    $form_action_query['save_and_update'] = true;
                    $form_action_query = http_build_query($form_action_query);
                    
                    $result[] = Html::submitButton(
                        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save & update'),
                        [
                            'class' => 'btn btn-info btn-icon',
                            'formaction' => parse_url($form_action, PHP_URL_PATH) . ($form_action_query ? "?$form_action_query" : null),
                        ]
                    );
                    
                    break;
                case 'save':
                    $result[] = Html::submitButton(
                        Html::tag('i', null, ['class' => 'fas fa-save']) . Yii::t('app', 'Save'),
                        ['class' => 'btn btn-primary btn-icon']
                    );
                    
                    break;
                default:
                    $result[] = $button;
            }
        }
        
        return Html::tag('div', implode(' ', $result ?? []), ['class' => 'float-right']);
    }
}
