<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaPenerimaanReturnPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penerimaan Return Pembelian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-penerimaan-return-pembelian-index">

    <div class="box box-default">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Penerimaan Return Pembelian Baru', ['create'], ['class' => 'btn btn-flat btn-primary']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'return_pembelian_id',

                    [
                        'label' => 'Kode Obat',
                        'value' => 'returnPembelian.obat_id',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:left;'
                        ],
                    ],
                    [
                        'label' => 'Nama Obat',
                        'value' => 'returnPembelian.obat.nama_obat',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:left;'
                        ],
                    ],
                    [
                        'label' => 'Jumlah',
                        'value' => 'returnPembelian.jumlah',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:center;'
                        ],
                    ],
                    [
                        'label' => 'Distributor',
                        'value' => 'returnPembelian.distributor.distributor',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:right;'
                        ],
                    ],
                    [
                        'label' => 'Tanggal',
                        'value' => function($model){
                            return date('d-m-Y', strtotime($model->tanggal));
                        },
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:right;'
                        ],
                    ],
                    // [
                    //     'label' => 'Waktu Entri',
                    //     'value' => function($model){
                    //         return date('d-m-Y h:i:s', $model->waktu_entri);
                    //     },
                    //     'contentOptions' => [
                    //         'style' => 'white-space:normal; text-align:right;'
                    //     ],
                    // ],
                    // [
                    //     'label' => 'Status',
                    //     'format' => 'raw', 
                    //     'value' => function($model){
                    //         if ($model->status == '0') {
                    //             return '<span class="label label-warning">Pending</span>';
                    //         }
                    //         else {
                    //             return 'Ok';
                    //         }
                    //     }
                    // ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>

</div>