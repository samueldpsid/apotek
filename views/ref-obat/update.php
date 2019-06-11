<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RefObat */
?>
<div class="ref-obat-update">

    <?= $this->render('_form-update', [
        'model' => $model,
        'DataProdusen' => $DataProdusen,
        'DataKategori' => $DataKategori,
        'DataSatuan' => $DataSatuan,

    ]) ?>

</div>
