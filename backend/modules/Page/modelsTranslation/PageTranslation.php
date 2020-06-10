<?php

namespace backend\modules\Page\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class PageTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'PageTranslation';
    }
    
    public function rules()
    {
        return [
            [['item_id', 'lang', 'name'], 'required'],
            [['item_id'], 'integer'],
            [['description'], 'string'],
            [['url'], 'unique'],
            [['lang'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 100],
        ];
    }
}
