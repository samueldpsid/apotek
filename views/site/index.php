<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\RefObat;
use app\models\RefDistributor;
use app\models\TaPenjualan;
use app\models\TaPembelian;
// use kartik\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Dashboard';

$jlh_penjualan = TaPenjualan::find()->count();
$jlh_pembelian = TaPenjualan::find()->count();
$jlh_obat = RefObat::find()->count();
$jlh_distributor = RefDistributor::find()->count();

?>

<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $jlh_pembelian ?></h3>

                        <p>Pembelian</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>
            <!-- ./col -->
            
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?= $jlh_penjualan ?></h3>

                        <p>Penjualan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?= $jlh_obat ?></h3>

                        <p>Obat</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-eyedropper"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?= $jlh_distributor ?></h3>

                        <p>Distributor</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a> -->
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="box box-default">
                    <div class="box-header"><h3 class="box-title">Obat Terlaris</h3></div>
                    <div class="box-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderObatTerlaris,
                            'filterModel' => $searchModelObatTerlaris,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'Kode Obat',
                                    'value' => 'obat_id',
                                    'contentOptions' => [
                                        'style' => 'white-space:normal; font-size:12px'
                                    ],
                                ],
                                [
                                    'label' => 'Nama Obat',
                                    'value' => 'obat.nama_obat',
                                    'contentOptions' => [
                                        'style' => 'white-space:normal; font-size:12px'
                                    ],
                                ],
                                [
                                    'label' => 'Jumlah',
                                    'value' => function($model) {
                                        return $model->sum_jumlah;
                                    },
                                    'contentOptions' => [
                                        'style' => 'white-space:normal; text-align:center; font-size:12px'
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box box-default">
                    <div class="box-header"><h3 class="box-title">Stok Habis</h3></div>
                    <div class="box-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderStok,
                            'filterModel' => $searchModelStok,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'label' => 'Kode Obat',
                                    'value' => 'id',
                                    'contentOptions' => [
                                        'style' => 'white-space:normal; font-size:12px'
                                    ],
                                ],
                                [
                                    'label' => 'Nama Obat',
                                    'value' => 'nama_obat',
                                    'contentOptions' => [
                                        'style' => 'white-space:normal; font-size:12px'
                                    ],
                                ],
                                [
                                    'label' => 'Kategori',
                                    'value' => 'kategori.kategori',
                                    'contentOptions' => [
                                        'style' => 'white-space:normal; text-align:center; font-size:12px'
                                    ],
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
