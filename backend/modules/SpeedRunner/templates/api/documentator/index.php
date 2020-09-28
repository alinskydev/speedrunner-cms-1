<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = Yii::$app->settings->site_name . ' API';

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
                    <a class="nav-link active" data-toggle="pill" href="#tab-general">
                        General
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
                <div id="tab-general" class="tab-pane active">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>
                                    Host url
                                </th>
                                <td>
                                    <?= Url::base(true); ?>
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
                                    List query arguments (as GET params)
                                </th>
                                <td>
                                    Sorting: ?sort=<b>{attribute}</b> or ?sort=<b>-{attribute}</b><br>
                                    Number of records: ?per-page=<b>{number}</b><br>
                                    Pagination: ?page=<b>{number}</b><br>
                                    Filtering: ?filter[<b>{attribute}</b>]=<b>{value}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <?php foreach ($result as $key => $r) { ?>
                    <div id="tab-<?= $key ?>" class="tab-pane fade">
                        <?php if ($r['behaviors']) { ?>
                            <h5 class="mb-3 text-danger">
                                <?= implode('<br>', $r['behaviors']) ?>
                            </h5>
                        <?php } ?>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                                <div class="font-weight-bold">
                                                    <?= strtoupper(implode('<br>', $a['methods'])) ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php
                                                    $params = $a['params'];
                                                    
                                                    if ($params['get']) {
                                                        echo Html::tag('b', 'GET') . ' {' . implode(', ', $params['get']) . '}<hr>';
                                                    }
                                                    
                                                    if ($params['post']) {
                                                        echo Html::tag('b', 'POST') . '<br>';
                                                        echo Html::tag('pre', json_encode($params['post'], JSON_PRETTY_PRINT));
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
