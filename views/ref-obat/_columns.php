<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'label' => 'Kode Obat'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama_obat',
        'label' => 'Nama Obat',
        'contentOptions' => [
            'style' => 'width:auto; white-space:normal;'
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'produsen.produsen',
        'label'=>'Produsen'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kategori.kategori',
        'label' => 'Kategori'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'satuan.satuan',
        'label' => 'Satuan'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Harga Beli',
        'value' => function($model) {
            return number_format($model->harga_beli, 0,",",".");
        },
        'contentOptions' => [
            'style' => 'width:auto; white-space:normal; text-align:right;'
        ],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'value' => function($model) {
            return number_format($model->harga_jual, 0,",",".");
        },
        'label'=>'Harga Jual',
        'contentOptions' => [
            'style' => 'width:auto; white-space:normal; text-align:right;'
        ]
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'value'=>'stok',
        'label'=>'Stok',
        'contentOptions' => [
            'style' => 'width:auto; white-space:normal; text-align:right;'
        ]
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{view} {update}',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   