<div style="font:14px sans-serif">
    <h1 style="padding: 10px 0; text-align: center;">
        You order secret key: <?= $data['key'] ?>
    </h1>
    
    <div style="text-align: center;">
        <a style="background:#337ab7; border-radius:3px;display:inline-block;padding:15px 30px 15px 30px;text-decoration:none;"
           href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['order/view', 'key' => $data['key']]) ?>"
        >
            <span style="color:#fff;font-weight:bold;text-transform:uppercase;">
                Link to your order
            </span>
        </a>
    </div>
</div>
