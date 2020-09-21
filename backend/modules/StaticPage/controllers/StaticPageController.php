<?php

namespace backend\modules\Staticpage\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use backend\modules\Staticpage\models\Staticpage;
use backend\modules\Staticpage\models\StaticpageBlock;


class StaticpageController extends Controller
{
    public function actionUpdate($location)
    {
        $model = Staticpage::find()->with(['blocks'])->where(['location' => $location])->one();

        if (!$model) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        if ($post_data = Yii::$app->request->post('StaticpageBlock')) {
            $blocks = ArrayHelper::index($model->blocks, 'id');
            
            foreach ($post_data as $key => $p_d) {
                if ($relation_mdl = ArrayHelper::getValue($blocks, $key)) {
                    $relation_mdl->value = ArrayHelper::getValue($p_d, 'value');
                    $relation_mdl->save();
                }
            }
        }

        if (Yii::$app->request->post('SeoMeta')) {
            $model->save();
        }

        if (Yii::$app->request->isPost) {
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'blocks' => ArrayHelper::index($model->blocks, null, 'part_name'),
        ]);
    }

    public function actionImageDelete($id)
    {
        if (!($model = StaticpageBlock::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        $images = $model->value;
        $key = array_search(Yii::$app->request->post('key'), $images);

        if ($key !== false) {
            Yii::$app->sr->file->delete($images[$key]);
            unset($images[$key]);

            if ($model->has_translation) {
                $json = ArrayHelper::getValue($model->oldAttributes, 'value');
                $json[Yii::$app->language] = array_values($images);

                return $model->updateAttributes(['value' => $json]);
            } else {
                return $model->updateAttributes(['value' => array_values($images)]);
            }
        }
    }

    public function actionImageSort($id)
    {
        if (!($model = StaticpageBlock::findOne($id))) {
            return $this->redirect(Yii::$app->request->referrer);
        }

        $images = $model->value;
        $stack = Yii::$app->request->post('sort')['stack'];
        $images = ArrayHelper::getColumn($stack, 'key');

        if ($model->has_translation) {
            $json = ArrayHelper::getValue($model->oldAttributes, 'value');
            $json[Yii::$app->language] = array_values($images);

            return $model->updateAttributes(['value' => $json]);
        } else {
            return $model->updateAttributes(['value' => array_values($images)]);
        }
    }
}
