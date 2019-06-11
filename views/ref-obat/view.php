<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RefObat */
?>
<div class="ref-obat-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kategori_id',
            'satuan_id',
            'produsen_id',
            'nama_obat',
            'harga_beli',
            'harga_jual',
            'stok',
        ],
    ]) ?>

</div>
