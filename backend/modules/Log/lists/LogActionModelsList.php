<?php

namespace backend\modules\Log\lists;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Log\models\LogAction;


class LogActionModelsList
{
    public static $data = null;
    
    public function __construct()
    {
        if (self::$data === null) {
            self::$data = [
                'Product' => [
                    'name' => 'Product',
                    'module' => Yii::t('app', 'Products'),
                    'label' => Yii::t('app', 'Products'),
                    'model' => ($model = new \backend\modules\Product\models\Product()),
                    'index_url' => ['/product/product/index', 'ProductSearch[id]'],
                    'relations' => [
                        'brand_id' => ['link' => 'brand', 'attr' => 'name'],
                        'main_category_id' => ['link' => 'mainCategory', 'attr' => 'name'],
                    ],
                    'attributes' => [
                        'translation' => (new \backend\modules\Product\models\Product())->behaviors['translation']->attributes,
                        'boolean' => [],
                        'enum' => [],
                        'text' => ['full_description'],
                        'json' => ['images', 'variations_tmp'],
                    ],
                ],
                
                'User' => [
                    'name' => 'User',
                    'module' => Yii::t('app', 'Users'),
                    'label' => Yii::t('app', 'Users'),
                    'model' => ($model = new \backend\modules\User\models\User()),
                    'index_url' => ['/user/user/index', 'UserSearch[id]'],
                    'relations' => [
                        'role_id' => ['link' => 'role', 'attr' => 'name'],
                    ],
                    'attributes' => [
                        'translation' => [],
                        'boolean' => [],
                        'enum' => [
                            'design_theme' => $model->enums->designThemes(),
                            'design_font' => $model->enums->designFonts(),
                        ],
                        'text' => [],
                        'json' => [],
                    ],
                ],
            ];
        }
    }
}