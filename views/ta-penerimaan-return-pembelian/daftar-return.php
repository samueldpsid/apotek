<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

?>

<?php Modal::begin([
    "id"=>"modal_obat",
    "header" => "Daftar Return Pembelian",
    "size" => "modal-lg",
    'footer'=>
        Html::button('Tutup',['class'=>'btn btn-flat btn-outline pull-right','data-dismiss'=>"modal"]),
    "options" => ['tabindex' => false],
    "footerOptions" => [
        "class" => "modal-footer bg-light-blue-active",
    ],
    "headerOptions" => [
        "class" => "modal-header bg-light-blue-active",
    ],
])?>
    <?=
        GridView::widget([
            'id'=>'crud-datatable-ssh',
            'dataProvider' => $dataProviderReturnPembelian,
            'filterModel' => $searchModelReturnPembelian,
            // 'showFooter'=>TRUE,
            'pjax'=>true,
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'width' => '30px',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'id',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'obat.nama_obat',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'jumlah',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'distributor.distributor',
                ],
                [
                    'format' => 'raw',
                    'value' => function($model) {
                        if ($model->status == 1) {
                            return " ";
                        }
                        else {
                            return Html::button('Pilih', [
                                'class' => 'btn bg-red btn-pilih',
                                'data-id' => $model->id,
                                'data-obat_id' => $model->obat_id,
                                'data-nama' => $model->obat->nama_obat,
                                'data-jumlah' => $model->jumlah,
                                'data-distributor' => $model->distributor_id,
                                'data-dismiss' => 'modal',
                            ]);
                        }
                    }
                ],
            ],
            'toolbar' => false,
            'striped' => true,
            'condensed' => false,
            'responsive' => true,
            'panel' => [
                'type' => 'default',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Daftar Obat',
            ],
        ]);
    ?>
<?php Modal::end(); ?>