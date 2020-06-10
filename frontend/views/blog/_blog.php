<div class="col-lg-4">
    <h2><?= $model->name ?></h2>
    <a class="btn btn-default" href="<?= Yii::$app->urlManager->createUrl(['blog/view', 'url' => $model->url]) ?>">link</a>
</div>