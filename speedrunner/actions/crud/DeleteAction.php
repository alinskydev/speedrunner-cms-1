<?php

namespace speedrunner\actions\crud;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;


class DeleteAction extends Action
{
    public ?string $success_message = 'Record has been deleted';
    
    public function run()
    {
        if (!($primary_key = ArrayHelper::getValue($this->controller->model->primaryKey(), 0))) {
            throw new \yii\web\HttpException(422, 'Primary key not set');
        }
        
        $id = Yii::$app->request->post('selection') ?? Yii::$app->request->get($primary_key);
        $models = $this->controller->model->find()->andWhere([$primary_key => $id])->all();
        
        $transaction = Yii::$app->db->beginTransaction();
        
        foreach ($models as $m) {
            if (!$m->delete()) {
                $transaction->rollBack();
                return $this->controller->redirect(Yii::$app->request->referrer);
            }
        }
        
        $transaction->commit();
        
        if ($this->success_message) {
            Yii::$app->session->addFlash('success', Yii::t('app', $this->success_message));
        }
        
        return $this->controller->redirect(Yii::$app->request->referrer);
    }
}
