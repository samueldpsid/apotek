<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\RefDistributorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-distributor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kd_distributor') ?>

    <?= $form->field($model, 'tahun') ?>

    <?= $form->field($model, 'kd_produsen') ?>

    <?= $form->field($model, 'nm_distributor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
