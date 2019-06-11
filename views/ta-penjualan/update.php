<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TaPenjualan */

$this->title = 'Update Ta Penjualan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ta Penjualans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-penjualan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
