<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaReturnPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Return Pembelian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-return-pembelian-index">
    <div class="box box-default">
        <div class="box-body">

            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Return Pembelian Baru', ['create'], ['class' => 'btn btn-flat btn-primary']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'obat_id',
                    [
                        'label' => 'Nama Obat',
                        'value' => 'obat.nama_obat',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:left;'
                        ],
                    ],
                    [
                        'label' => 'Jumlah',
                        'value' => 'jumlah',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:center;'
                        ],
                    ],
                    [
                        'label' => 'Distributor',
                        'value' => 'distributor.distributor',
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
                    [
                        'label' => 'Status',
                        'format' => 'raw', 
                        'value' => function($model){
                            if ($model->status == '0') {
                                return '<span class="label label-warning">Returned</span>';
                            }
                            else {
                                return '<span class="label label-success">Received</span>';
                            }
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
