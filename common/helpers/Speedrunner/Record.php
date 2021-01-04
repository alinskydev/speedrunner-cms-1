<?php

namespace common\helpers\Speedrunner;

use Yii;
use yii\helpers\ArrayHelper;

use backend\modules\Staticpage\models\Staticpage;


class Record
{
    public function staticpage($name)
    {
        $result['page'] = Staticpage::find()->with(['blocks'])->andWhere(['name' => $name])->one();
        $result['blocks'] = ArrayHelper::map($result['page']->blocks, 'name', 'value');
        
        return $result;
    }
}
