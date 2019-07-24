<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

?>

<?php Modal::begin([
    "id"=>"modal_obat",
    "header" => "Daftar Obat",
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
            'dataProvider' => $dataProviderObat,
            'filterModel' => $searchModelObat,
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
                    'contentOptions' => [
                        'style' => 'white-space:normal; vertical-align: middle;'
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'nama_obat',
                    'contentOptions' => [
                        'style' => 'white-space:normal; vertical-align: middle;'
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'kategori.kategori',
                    'contentOptions' => [
                        'style' => 'white-space:normal; vertical-align: middle;'
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'attribute'=>'satuan.satuan',
                    'contentOptions' => [
                        'style' => 'white-space:normal; text-align:center; vertical-align: middle;'
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'value' => function($model) {
                        return number_format($model->harga_beli, 0,",",".");
                    },
                    'label'=>'Harga Beli',
                    'contentOptions' => [
                        'style' => 'white-space:normal; text-align:right; vertical-align: middle;'
                    ], 
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'value' => function($model) {
                        return number_format($model->harga_jual, 0,",",".");
                    },
                    'label'=>'Harga Jual',
                    'contentOptions' => [
                        'style' => 'white-space:normal; text-align:right; vertical-align: middle;'
                    ],
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'value'=>'stok',
                    'label' => 'Stok',
                    'contentOptions' => [
                        'style' => 'white-space:normal; text-align:right; vertical-align: middle;'
                    ],
                ],
                [
                    'format' => 'raw',
                    'value' => function($model) {
                        return Html::button('Pilih', [
                            'class' => 'btn btn-sm bg-red btn-pilih',
                            'data-kode' => $model->id,
                            'data-nama' => $model->nama_obat,
                            'data-kategori' => $model->kategori_id,
                            'data-satuan' => $model->satuan_id,
                            'data-beli' => $model->harga_beli,
                            'data-harga' => $model->harga_jual,
                            'data-stok' => $model->stok,
                            'data-dismiss' => 'modal',
                        ]);
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