<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaReturnPembelian */

$this->title = 'Return Pembelian Baru';
$this->params['breadcrumbs'][] = ['label' => 'Ta Return Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-return-pembelian-create">

    <?= $this->render('_form', [
        'model' => $model,
        'searchModelObat' => $searchModelObat,
        'dataProviderObat' => $dataProviderObat,
        'DataDistributor' => $DataDistributor,
        'modelReturnPembelian' => $modelReturnPembelian,
    ]) ?>

</div>
