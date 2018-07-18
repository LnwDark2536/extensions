<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Url::to(['/runner/default/index']),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems = [
            ['label' => '<i class="glyphicon glyphicon-ok-circle"></i> ตรวจสอบหลักฐานการโอน', 'url' => ['/runner/default/check-premise']],
            ['label' => '<i class="glyphicon glyphicon-search"></i> ตรวจสอบรับเสื้อ', 'url' => ['/runner/register/search-user']],
            ['label' => '<i class="glyphicon glyphicon-user"></i> จัดการข้อมูลสมัครทั้งหมด', 'url' => ['/runner/register/index']],
            ['label' => '<i class="glyphicon glyphicon-tag"></i> รายงาน', 'url' => ['/runner/register/report-all']],
            ['label' => '<i class="glyphicon glyphicon-send"></i> จัดส่งเสื้อ', 'url' => ['/runner/register/post-sum-day']],
        ];
        if(\app\models\User::findOne(Yii::$app->user->id)->role ==\app\models\User::ROLE_ADMIN){
            $menuItems[] = [
                'label' => 'ผู้ใช้งาน (' . Yii::$app->user->identity->username . ')',
                'items' => [
                    ['label' => 'จัดการข้อมูลผู้ใช้งาน', 'url' => '/runner/register/index' ],
                    ['label' => 'แก้ไขข้อมูลส่วนตัว', 'url' => '/runner/user/profile-view' ],

                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                ],

            ] ;
        }else{

            $menuItems[] = [

                'label' => 'ผู้ใช้งาน (' . Yii::$app->user->identity->username . ')',
                'items' => [
                    ['label' => 'แก้ไขข้อมูลส่วนตัว', 'url' => '/runner/user/profile-view' ],
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                ],

            ] ;
        }

//        $menuItems[] =
//            '<li>'
//            . Html::beginForm(['/site/logout'], 'post')
//            . Html::submitButton(
//                'Logout (' . Yii::$app->user->identity->username . ')',
//                ['class' => 'btn btn-link logout']
//            )
//            . Html::endForm()
//            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false
    ]);


    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
