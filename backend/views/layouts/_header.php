<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

use backend\modules\User\models\UserNotification;

$user = Yii::$app->user->identity;
$langs = Yii::$app->services->i18n::$languages;

$notifications = UserNotification::find()->andWhere(['user_id' => Yii::$app->user->id])->orderBy('id DESC')->limit(10)->all();

?>

<header>
    <div class="container-fluid">
        <div class="header-right">
            <div class="item dropdown">
                <button type="button" class="btn btn-link dropdown-toggle flag-wrapper" data-toggle="dropdown">
                    <img src="<?= Yii::$app->services->image->thumb($langs[Yii::$app->language]['image'], [30, 20], 'crop') ?>">
                </button>
                
                <div class="dropdown-menu dropdown-menu-right">
                    <?php foreach ($langs as $l) { ?>
                        <a class="dropdown-item small font-weight-bold" href="<?= $l['url'] ?>">
                            <img class="mr-1" src="<?= Yii::$app->services->image->thumb($l['image'], [30, 20], 'crop') ?>">
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
                            <?= ArrayHelper::getValue($user, 'role.name') ?>
                        </small>
                    </div>
                    
                    <div class="dropdown-divider"></div>
                    
                    <?= Yii::$app->helpers->html->allowedLink(
                        Html::tag('i', '&nbsp;', ['class' => 'fas fa-edit']) . Yii::t('app', 'Update'),
                        ['/user/user/profile-update'],
                        ['class' => 'dropdown-item px-3']
                    ) ?>
                    
                    <?= Html::a(
                        Html::tag('i', '&nbsp;', ['class' => 'fas fa-sign-out-alt']) . Yii::t('app', 'Logout'),
                        ['/auth/logout'],
                        ['class' => 'dropdown-item px-3', 'data-method' => 'post']
                    ) ?>
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
                                $label = ArrayHelper::getValue($n->service->actionData(), 'label');
                                
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
            
            <?php if ($show_nav_toggler) { ?>
                <div class="item">
                    <button type="button" class="btn btn-link nav-full-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            <?php } ?>
        </div>
        
        <div class="header-left">
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        </div>
    </div>
</header>