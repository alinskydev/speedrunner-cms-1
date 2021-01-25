<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

use backend\modules\User\models\UserNotification;
use backend\modules\User\services\UserNotificationService;

$user = Yii::$app->user->identity;
$langs = Yii::$app->services->i18n::$languages;

$breadcrumbs = $this->params['breadcrumbs'] ?? [];
$bookmark_add_value = implode(' &rsaquo; ', ArrayHelper::getColumn($breadcrumbs, 'label'));

$notifications = UserNotification::find()->andWhere(['user_id' => Yii::$app->user->id])->orderBy('id DESC')->limit(10)->all();

?>

<header>
    <div class="container-fluid">
        <div class="header-right">
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle flag-wrapper" data-toggle="dropdown">
                    <img src="<?= Yii::$app->services->image->thumb($langs[Yii::$app->language]['image'], [30, 20]) ?>">
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <?php foreach ($langs as $l) { ?>
                        <a class="dropdown-item small font-weight-bold" href="<?= $l['url'] ?>">
                            <img class="mr-1" src="<?= Yii::$app->services->image->thumb($l['image'], [30, 20]) ?>">
                            <?= $l['name'] ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
            
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-user-circle"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="px-3 pt-2 pb-1">
                        <div class="h5 m-0">
                            <?= $user->full_name ?>
                        </div>
                        <small>
                            <?= ArrayHelper::getValue($user->roles(), "$user->role.label") ?>
                        </small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item px-3" href="<?= Yii::$app->urlManager->createUrl(['site/change-password']) ?>">
                        <i class="fas fa-key">&nbsp;</i>
                        <?= Yii::t('app', 'Change password') ?>
                    </a>
                    <a class="dropdown-item px-3" href="<?= Yii::$app->urlManager->createUrl(['site/logout']) ?>">
                        <i class="fas fa-sign-out-alt">&nbsp;</i>
                        <?= Yii::t('app', 'Logout') ?>
                    </a>
                </div>
            </div>
            
            <div class="item dropdown">
                <button type="button" class="btn <?= $notifications ? 'btn-danger text-white' : 'btn-link' ?> dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right main-shadow">
                    <?php
                        if ($notifications) {
                            foreach ($notifications as $key => $n) {
                                $notification_service = new UserNotificationService($n);
                                $label = ArrayHelper::getValue($notification_service->actionData(), 'label');
                                
                                echo Html::a(
                                    Html::tag('i', '&nbsp;', ['class' => 'fas fa-check-circle']) . $label,
                                    ['/user/notification/view', 'id' => $n->id],
                                    [
                                        'class' => 'dropdown-item px-3',
                                    ]
                                ) . Html::tag('div', null, ['class' => 'dropdown-divider']);
                            }
                            
                            echo Html::a(
                                Html::tag('i', '&nbsp;', ['class' => 'fas fa-trash']) . Yii::t('app', 'Clear all'),
                                ['/user/notification/clear'],
                                [
                                    'class' => 'dropdown-item bg-primary text-white px-3 py-3',
                                ]
                            );
                        } else {
                            echo Html::tag('div', Yii::t('app', 'No notifications'), ['class' => 'px-4']);
                        }
                    ?>
                </div>
            </div>
            
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-bookmark"></i>
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="px-3 py-1">
                        <div class="h5 m-0">
                            <?= Yii::t('app', 'Bookmarks') ?>
                        </div>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <div class="px-3">
                        <?php
                            foreach (Yii::$app->session->get('bookmarks', []) as $key => $b) {
                                $buttons = [
                                    Html::a(
                                        Html::tag('i', null, ['class' => 'fas fa-external-link-alt']) . $b,
                                        $key,
                                        ['class' => 'btn btn-primary btn-block btn-icon']
                                    ),
                                    Html::a(
                                        Html::tag('i', '&nbsp;', ['class' => 'fas fa-times']),
                                        ['/session/remove'],
                                        [
                                            'class' => 'btn btn-danger',
                                            'data-method' => 'post',
                                            'data-params' => [
                                                'name' => 'bookmarks',
                                                'value' => $key,
                                            ],
                                        ]
                                    ),
                                ];
                                
                                echo Html::tag('div', implode(null, $buttons), ['class' => 'btn-group btn-block text-nowrap']);
                            }
                        ?>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <div class="px-3">
                        <?php
                            echo Html::a(
                                Html::tag('i', null, ['class' => 'fas fa-plus-square']) . Yii::t('app', 'Add'),
                                ['/session/set'],
                                [
                                    'class' => 'btn btn-success btn-block btn-icon',
                                    'data-method' => 'post',
                                    'data-params' => [
                                        'name' => 'bookmarks',
                                        'value' => $bookmark_add_value ?: Yii::t('app', 'Link'),
                                    ],
                                ]
                            );
                        ?>
                    </div>
                </div>
            </div>
            
            <?php if ($show_nav_toggler) { ?>
                <div class="item">
                    <button type="button" class="btn btn-link nav-full-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        
        <div class="header-left">
            <?= Breadcrumbs::widget([
                'links' => $breadcrumbs,
                'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => ['/']],
                'options' => ['class' => 'breadcrumbs'],
                'activeItemTemplate' => '<li><span>{link}</span></li>'
            ]) ?>
        </div>
    </div>
</header>