<?php

namespace backend\modules\Log\helpers;

use Yii;
use yii\helpers\ArrayHelper;


trait LogActionHelper
{
    public function modelClasses($model = null)
    {
        return [
            'Product' => [
                'name' => 'Product',
                'module' => Yii::t('app', 'Products'),
                'label' => Yii::t('app', 'Products'),
                'model' => new \backend\modules\Product\models\Product,
                'index_url' => ['/product/product/index', 'ProductSearch[id]' => ArrayHelper::getValue($model, 'model_id')],
                'relations' => [
                    'brand_id' => ['link' => 'brand', 'attr' => 'name'],
                    'main_category_id' => ['link' => 'mainCategory', 'attr' => 'name'],
                ],
                'attributes' => [
                    'translation' => (new \backend\modules\Product\models\Product)->behaviors['translation']->attributes,
                    'boolean' => [],
                    'select' => [],
                    'text' => ['full_description'],
                    'json' => ['images', 'variations_tmp'],
                ],
            ],
            
            'User' => [
                'name' => 'User',
                'module' => Yii::t('app', 'Users'),
                'label' => Yii::t('app', 'Users'),
                'model' => new \backend\modules\User\models\User,
                'index_url' => ['/user/user/index', 'UserSearch[id]' => ArrayHelper::getValue($model, 'model_id')],
                'relations' => [],
                'attributes' => [
                    'translation' => [],
                    'boolean' => [],
                    'select' => ['role' => 'roles', 'design_theme' => 'designThemes', 'design_font' => 'designFonts'],
                    'text' => [],
                    'json' => [],
                ],
            ],
        ];
    }
}