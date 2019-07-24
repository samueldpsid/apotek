<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaPenerimaanReturnPembelian */

$this->title = 'Penerimaan Return Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Ta Penerimaan Return Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-penerimaan-return-pembelian-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelObat' => $modelObat,
        'DataDistributor' => $DataDistributor,
        'searchModelReturnPembelian' => $searchModelReturnPembelian,
        'dataProviderReturnPembelian' => $dataProviderReturnPembelian,
    ]) ?>

</div>
