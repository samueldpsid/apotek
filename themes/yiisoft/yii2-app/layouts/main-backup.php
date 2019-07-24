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

                $menuItems = [
                    ['label' => 'Dashboard', 'url' => ['/site/index']],
                ];
                if (Yii::$app->user->isGuest) {
                    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
                }
                else if (Yii::$app->manajemen->getPenugasan() == "Kasir") {
                    $menuItems[] = [
                        'label' => 'Penjualan',
                        'items' => [
                            [
                                'label' => 'Penjualan Baru', 
                                'url' => ['/ta-penjualan/create'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Data Penjualan',
                                'url' => ['/ta-penjualan/index'],
                            ],
                        ]
                    ];

                    $menuItems[] = [
                        'label' => 'Logout (' . Yii::$app->user->identity->nama . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ];
                }
                 else if (Yii::$app->manajemen->getPenugasan() == "Admin") {
                    $menuItems[] = [
                        'label' => 'Penjualan',
                        'items' => [
                            [
                                'label' => 'Data Penjualan',
                                'url' => ['/ta-penjualan/index'],
                            ],
                        ]
                    ];

                    $menuItems[] = [
                        'label' => 'Pembelian',
                        'items' => [
                            [
                                'label' => 'Pembelian Baru', 
                                'url' => ['/ta-pembelian/create'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Data Pembelian',
                                'url' => ['/ta-pembelian/index'],
                            ],
                        ]
                    ];

                    $menuItems[] = [
                        'label' => 'Return Obat',
                        'items' => [
                            [
                                'label' => 'Return Pembelian Obat', 
                                'url' => ['/ta-return-pembelian/index'],
                                'icon'=> 'cog',
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Penerimaan Return Pembelian Obat',
                                'url' => ['/ta-penerimaan-return-pembelian/index'],
                            ],
                        ]
                    ];

                    $menuItems[] = [
                        'label' => 'Data Master',
                        'items' => [
                            [
                                'label' => 'Data Obat', 
                                'url' => ['/ref-obat/index'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Kategori Obat',
                                'url' => ['/ref-kategori/index'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Satuan Obat',
                                'url' => ['/ref-satuan/index'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Produsen Obat', 
                                'url' => ['/ref-produsen/index'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Distributor Obat',
                                'url' => ['/ref-distributor/index'],
                            ],
                        ]
                    ];
                    $menuItems[] = [
                        'label' => 'Laporan',
                        'items' => [
                            [
                                'label' => 'Laporan Pembelian', 
                                'url' => ['/laporan/pembelian'],
                                'icon'=> 'cog',
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Laporan Penjualan',
                                'url' => ['/laporan/penjualan'],
                            ],
                        ]
                    ];

                    $menuItems[] = [
                        'label' => 'Logout (' . Yii::$app->user->identity->nama . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ];
                }
                else {
                    $menuItems[] = [
                        'label' => 'GII',
                        'url' => ['/gii'],
                    ];

                    $menuItems[] = [
                        'label' => 'RBAC',
                        'items' => [
                            // [
                            //     'label' => 'User', 
                            //     'url' => ['/admin/user'],
                            // ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Assignment',
                                'url' => ['/admin/assignment'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Role',
                                'url' => ['/admin/role'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Route',
                                'url' => ['/admin/route'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Permission',
                                'url' => ['/admin/permission'],
                            ],
                            '<li class="divider"></li>',
                            [
                                'label' => 'Menu',
                                'url' => ['/admin/menu'],
                            ],
                        ]
                    ];

                    $menuItems[] = ['label' => 'User', 'url' => ['/user/index']];

                    $menuItems[] = [
                        'label' => 'Logout (' . Yii::$app->user->identity->nama . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ];
                }


                // $menuItems = Helper::filter($menuItems);

                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $menuItems,
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
