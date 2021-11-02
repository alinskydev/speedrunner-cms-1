<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->services->settings->site_name . ' API';

$tabs = array_keys($result);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/speedrunner.css">
    <link rel="stylesheet" href="assets/css/extra.css">
    
    <title><?= $this->title ?></title>
</head>

<body>

<div class="content">
    <h2 class="main-title">
        <?= $this->title ?>
    </h2>
    
    <div class="row">
        <div class="col-lg-2 col-md-3">
            <ul class="nav flex-column nav-pills main-shadow" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#tab-information">
                        Information
                    </a>
                </li>
                
                <?php foreach ($result as $key => $r) { ?>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#tab-<?= $key ?>">
                            <?= $key ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        
        <div class="col-lg-10 col-md-9 mt-3 mt-md-0">
            <div class="tab-content main-shadow p-3">
                <div id="tab-information" class="tab-pane active">
                    <table class="table m-0">
                        <tbody>
                            <tr>
                                <th>
                                    Base url
                                </th>
                                <td>
                                    <?= Yii::$app->request->hostInfo ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    Formats
                                </th>
                                <td>
                                    JSON or Multipart form data (for files transferring)
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    Auth
                                </th>
                                <td>
                                    Basic (send <b>access_token</b> as <b>username</b>)<br>
                                    <b>Access_token</b> will be changed after setting a new password
                                </td>
                            </tr>
                            
                            <tr>
                                <th>
                                    List query arguments (as GET params)
                                </th>
                                <td>
                                    To change language: /api/<b>{lang}</b>/{route}<br>
                                    Filtering: ?filter[<b>{attribute}</b>]=<b>{value}</b><br>
                                    Sorting: ?sort=<b>{attribute}</b> or ?sort=<b>-{attribute}</b><br>
                                    Number of records: ?per-page=<b>{number}</b><br>
                                    Pagination: ?page=<b>{number}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php foreach ($result as $key => $r) { ?>
                    <div id="tab-<?= $key ?>" class="tab-pane fade">
                        <?php if (isset($r['behaviors'])) { ?>
                            <?= Html::tag('h5', implode('<br>', $r['behaviors']), ['class' => 'mb-3 text-danger']) ?>
                        <?php } ?>
                        
                        <?php if (isset($r['comment'])) { ?>
                            <?= Html::tag('h6', $r['comment'], [
                                'class' => 'mb-4 text-secondary',
                                'style' => 'white-space: pre;',
                            ]) ?>
                        <?php } ?>
                        
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 3%;">#</th>
                                        <th style="width: 25%;">Url</th>
                                        <th style="width: 12%;">Methods</th>
                                        <th style="width: 60%;">Params</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach ($r['actions'] as $a_key => $a) { ?>
                                        <tr>
                                            <td>
                                                <?= $a_key + 1 ?>
                                            </td>
                                            <td>
                                                <code class="font-weight-bold">
                                                    <?= $a['url'] ?>
                                                </code>
                                            </td>
                                            <td>
                                                <?= strtoupper(implode('<br>', $a['methods'])) ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $params = $a['params'];
                                                    
                                                    if ($params['get']) {
                                                        echo '{' . implode(', ', $params['get']) . '}';
                                                    }
                                                    
                                                    if ($params['post']) {
                                                        echo Html::tag('pre', json_encode($params['post'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script src="assets/js/jquery.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>
