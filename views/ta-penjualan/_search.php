<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\TaPenjualanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-penjualan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'grand_total') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'waktu_entri') ?>

    <?= $form->field($model, 'kd_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
