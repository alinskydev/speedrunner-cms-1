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
        $settings = SystemSettings::find()->indexBy('id')->orderBy('sort')->all();
        
        if ($post_data = Yii::$app->request->post('SystemSettings')) {
            foreach ($post_data as $key => $p_d) {
                if ($model = ArrayHelper::getValue($settings, $key)) {
                    $model->value = ArrayHelper::getValue($p_d, 'value');
                    $model->save();
                    
                    Yii::$app->session->setFlash('success', [Yii::t('app', 'Record has been saved')]);
                }
            }
            
            return $this->refresh();
        }
        
        return $this->render('update', [
            'settings' => $settings,
        ]);
    }
    
    public function actionSort()
    {
        $post = Yii::$app->request->post();
        
        if ($post['oldIndex'] > $post['newIndex']){
            $params = ['and', ['>=', 'sort', $post['newIndex']], ['<', 'sort', $post['oldIndex']]];
            $counter = 1;
        } else {
            $params = ['and', ['<=', 'sort', $post['newIndex']], ['>', 'sort', $post['oldIndex']]];
            $counter = -1;
        }
        
        SystemSettings::updateAllCounters(['sort' => $counter], $params);
        SystemSettings::updateAll(['sort' => $post['newIndex']], ['id' => $post['id']]);
    }
}
