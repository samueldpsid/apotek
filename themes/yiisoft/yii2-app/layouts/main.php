<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use mdm\admin\components\MenuHelper;
use mdm\admin\components\Helper;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <!-- <body class="hold-transition skin-blue sidebar-mini"> -->
        <body class="hold-transition <?= \dmstr\helpers\AdminLteHelper::skinClass() ?> layout-top-nav">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <header class="main-header">

            <?php

                NavBar::begin([
                    'brandLabel' => Yii::$app->name,
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse',
                    ],
                ]);

                if (!empty(Yii::$app->user->identity->id)) {
                    $items = MenuHelper::getAssignedMenu(Yii::$app->user->identity->id);

                    $items[] = [
                        'label' => 'Logout (' . Yii::$app->user->identity->nama . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ];
                } 
                else {
                    // $items = array();
                    $items[] = ['label' => 'Login', 'url' => ['/site/login']];
                }

                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $items,
                ]);

                NavBar::end();
            ?>

        </header>

        <?php 
            // echo $this->render(
            // 'header.php',
            // ['directoryAsset' => $directoryAsset]
            // ) 
        ?>

        <?php 
            // echo $this->render(
            // 'left.php',
            // ['directoryAsset' => $directoryAsset]
            // )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
