<?php

echo '<?php';

?>


namespace backend\modules\<?= $model->module_name ?>\modelsTranslation;

use Yii;
use common\components\framework\ActiveRecord;


class <?= $model->table_name?>Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '<?= $model->table_name?>Translation';
    }
}
