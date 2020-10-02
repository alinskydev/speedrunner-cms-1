<?php

namespace backend\modules\System\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\modules\System\models\SystemSettings;


class SettingsController extends Controller
{
    public function actionUpdate()
    {
        if ($post_data = Yii::$app->request->post('SystemSettings')) {
            foreach ($post_data as $key => $p_d) {
                if ($model = SystemSettings::find()->andWhere(['name' => $key])->one()) {
                    $model->label = ArrayHelper::getValue($p_d, 'label');
                    $model->value = ArrayHelper::getValue($p_d, 'value');
                    $model->save();
                }
            }
            
            return $this->refresh();
        }
        
        return $this->render('update', [
            'settings' => SystemSettings::find()->orderBy('sort')->all(),
        ]);
    }
    
    public function actionSort()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            
            if ($post['oldIndex'] > $post['newIndex']){
                $params = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
                $counter = 1;
            } else {
                $params = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
                $counter = -1;
            }
            
            SystemSettings::updateAllCounters([
                'sort' => $counter,
            ], $params);
            
            SystemSettings::updateAll([
                'sort' => $post['newIndex'],
            ], ['id' => $post['id']]);
            
            return true;
        }
    }
}
