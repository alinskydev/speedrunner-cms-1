<?php

namespace speedrunner\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\helpers\VarDumper;


class HtmlHelper
{
    public static function allowedLink($text, $route = null, $options = [])
    {
        if ($route !== null) {
            $role = ArrayHelper::getValue(Yii::$app->user->identity, 'role');
            
            if (!$role || !$role->service->isAllowedByRoute(Yii::$app->urlManager->getRoute($route))) {
                return null;
            }
        }
        
        return Html::a($text, $route, $options);
    }
    
    public static function dump($var, $die = false, $depth = 10, $highlight = true)
    {
        if (Yii::$app->params['is_development_ip']) {
            echo VarDumper::dump($var, $depth, $highlight);
            $die ? die : null;
        }
    }
    
    public static function purify($value, $allowed_chars = [])
    {
        $config = \HTMLPurifier_HTML5Config::createDefault();
        $config->set('Cache.DefinitionImpl', null);
        $config->set('HTML.SafeIframe', true);
        $config->set('HTML.MaxImgLength', null);
        $config->set('Attr.AllowedFrameTargets', ['_blank', '_self', '_parent', '_top']);
        $config->set('CSS.MaxImgLength', null);
        
        $html_definition = $config->getDefinition('HTML', true, true);
        
        $html_definition->addElement('meta', 'Inline', 'Empty', 'Common', [
            'name' => 'Text',
            'property' => 'Text',
            'content' => 'Text',
        ]);
        
        $html_definition->addElement('iframe', 'Block', 'Inline', 'Common', [
            'src' => 'Text',
        ]);
        
        $purifier = new \HTMLPurifier($config);
        $value = $purifier->purify($value);
        
        foreach ($allowed_chars as $from => $to) {
            $value = str_replace($from, $to, $value);
        }
        
        return $value;
    }
    
    public static function picture($image_url, $width_height = null, $thumb_type = 'resize', $options = [])
    {
        if ($width_height) {
            $image_url = ImageHelper::thumb($image_url, $width_height, $thumb_type);
        }
        
        $image = Yii::getAlias('@frontend/web') . $image_url;
        
        if (!is_file($image)) {
            return false;
        }
        
        $image_mime_type = mime_content_type($image);
        
        if (in_array($image_mime_type, ['image/png', 'image/jpeg'])) {
            $dir = Yii::getAlias('@frontend/web/assets/thumbs/webp');
            FileHelper::createDirectory($dir);
            
            $image_name = md5(filemtime($image) . filesize($image)) . '.webp';
            $source_image = "$dir/$image_name";
            
            if (!is_file($source_image)) {
                switch ($image_mime_type) {
                    case 'image/png':
                        $image = imagecreatefrompng($image);
		        	    imagepalettetotruecolor($image);
		        	    imagealphablending($image, true);
		        	    imagesavealpha($image, true);
                        break;
                        
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($image);
		        	    imagepalettetotruecolor($image);
                        break;
                }
                
                imagewebp($image, $source_image);
            }
            
            $source_image = str_replace(Yii::getAlias('@frontend/web'), null, $source_image);
        } else {
            $source_image = $image_url;
        }
        
        $result = [
            Html::beginTag('picture', $options),
            Html::tag('source', null, [
                'srcset' => $source_image,
                'type' => mime_content_type(Yii::getAlias("@frontend/web/$source_image")),
            ]),
            Html::img($image_url),
            Html::endTag('picture'),
        ];
        
        return implode(null, $result);
    }
    
    public static function pageTitle($model, $attribute = 'name', $action_label = 'Update')
    {
        if ($model->isNewRecord) {
            return Yii::t('app', 'Create');
        } else {
            $value = $model->{$attribute};
            $value = is_array($value) ? ArrayHelper::getValue($value, Yii::$app->language) : $value;
            return Yii::t('app', "$action_label: {value}", ['value' => $value]);
        }
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
