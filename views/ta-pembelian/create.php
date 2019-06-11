<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaPembelian */

$this->title = 'Pembelian Baru';
$this->params['breadcrumbs'][] = ['label' => 'Ta Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-pembelian-create">

    <?= $this->render('_form', [
        'modelPembelian' => $modelPembelian,
        'obat' => $obat,
        'searchModelObat' => $searchModelObat,
        'dataProviderObat' => $dataProviderObat,
        'DataDistributor' => $DataDistributor,
    ]) ?>

</div>
