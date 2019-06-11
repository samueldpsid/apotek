<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaPenjualan */

$this->title = 'Penjualan Baru';
$this->params['breadcrumbs'][] = ['label' => 'Ta Penjualans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-penjualan-create">

    <?= $this->render('_form', [
        'modelObat' => $modelObat,
        'obat' => $obat,
        'searchModelObat' => $searchModelObat,
        'dataProviderObat' => $dataProviderObat,
    ]) ?>

</div>
