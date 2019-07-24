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
            } else {
                $menuItems[] = [
                    'label' => 'GII',
                    'url' => ['/gii'],
                ];
                $menuItems[] = [
                    'label' => 'RBAC',
                    'items' => [
                        [
                            'label' => 'User', 
                            'url' => ['/admin/user'],
                            'icon'=> 'cog',
                        ],
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
                $menuItems[] = [
                    'label' => 'Pembelian',
                    'items' => [
                        [
                            'label' => 'Pembelian Baru', 
                            'url' => ['/ta-pembelian/create'],
                            'icon'=> 'cog',
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => 'Data Pembelian',
                            'url' => ['/ta-pembelian'],
                        ],
                    ]
                ];
                $menuItems[] = [
                    'label' => 'Penjualan',
                    'items' => [
                        [
                            'label' => 'Penjualan Baru', 
                            'url' => ['/ta-penjualan/create'],
                            'icon'=> 'cog',
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => 'Data Penjualan',
                            'url' => ['/ta-penjualan'],
                        ],
                    ]
                ];
                $menuItems[] = [
                    'label' => 'Data Master',
                    'items' => [
                        [
                            'label' => 'Data Obat', 
                            'url' => ['/ref-obat'],
                            'icon'=> 'cog',
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => 'Kategori Obat',
                            'url' => ['/ref-kategori'],
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => 'Satuan Obat',
                            'url' => ['/ref-satuan'],
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => 'Produsen Obat', 
                            'url' => ['/ref-produsen'],
                            'icon'=> 'cog',
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => 'Distributor Obat',
                            'url' => ['/ref-distributor'],
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
                $menuItems[]=
                Yii::$app->user->isGuest ? (
                    ['label' => 'Login', 'url' => ['/site/login']]) :

                    '<li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="'.$directoryAsset.'/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                            <span class="hidden-xs">'.Yii::$app->user->identity->username.'</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="'.$directoryAsset.'/img/user2-160x160.jpg" class="img-circle"
                                     alt="User Image"/>

                                <p>
                                    '.Yii::$app->user->identity->username.' - Aplikasi Apotek
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-primary btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    '.Html::a(
                                        'Sign out',
                                        ['/site/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat']
                                    ).'
                                </div>
                            </li>
                        </ul>
                    </li>';
                // (
                //     '<li>'
                //     . Html::beginForm(['/site/logout'], 'post')
                //     . Html::submitButton(
                //     'Logout (' . Yii::$app->user->identity->username . ')',
                //     ['class' => 'btn btn-link logout']
                // )
                // . Html::endForm()
                // . '</li>'
                // );
            }


            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>