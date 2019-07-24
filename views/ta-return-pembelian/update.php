<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaReturnPembelian */

$this->title = 'Update Return Pembelian: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Return Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-return-pembelian-update">

    <?= $this->render('_form', [
        'model' => $model,
        'searchModelObat' => $searchModelObat,
        'dataProviderObat' => $dataProviderObat,
        'DataDistributor' => $DataDistributor,
        'modelReturnPembelian' => $modelReturnPembelian,
    ]) ?>

</div>
