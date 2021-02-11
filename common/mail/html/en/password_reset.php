<div style="font:14px sans-serif;">
    <h1 style="padding: 10px 0; text-align: center;">
        Password recovery
    </h1>
    
    <div style="text-align: center;">
        <a style="background:#337ab7; border-radius:3px;display:inline-block;padding:15px 30px 15px 30px;text-decoration:none;"
           href="<?= Yii::$app->urlManagerFrontend->createAbsoluteUrl(['auth/reset-password', 'token' => $data['token']]) ?>"
        >
            <span style="color:#fff;font-weight:bold;text-transform:uppercase;">
                Reset password
            </span>
        </a>
    </div>
</div>
