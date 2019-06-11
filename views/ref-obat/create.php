<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\RefObat */

?>
<div class="ref-obat-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelObat' => $modelObat,
        'DataProdusen' => $DataProdusen,
        'DataKategori' => $DataKategori,
        'DataSatuan' => $DataSatuan,
    ]) ?>
</div>
