<?php

namespace common\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class DeleteAction extends Action
{
    public ?string $success_message = 'Record has been deleted';
    
    public function run()
    {
        $id = Yii::$app->request->post('selection') ?? Yii::$app->request->get('id');
        $models = $this->controller->model->find()->andWhere(['id' => $id])->all();
        
        $transaction = Yii::$app->db->beginTransaction();
        
        foreach ($models as $m) {
            if (!$m->delete()) {
                $transaction->rollBack();
                return $this->controller->redirect(Yii::$app->request->referrer);
            }
        }
        
        $transaction->commit();
        
        if ($this->success_message) {
            Yii::$app->session->setFlash('success', [Yii::t('app', $this->success_message)]);
        }
        
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
