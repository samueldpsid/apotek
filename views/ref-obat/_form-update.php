<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RefObat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-obat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength'=>true, 'autocomplete'=>'off', 'readOnly' => true])->label('Kode Obat') ?>

    <?= $form->field($model, 'nama_obat')->textInput(['maxlength' => true])->label('Nama Obat') ?>

    <?= $form->field($model, 'kategori_id')->dropDownList($DataKategori, ['prompt' => '- Pilih Kategori -'])->label('Kategori') ?>

    <?= $form->field($model, 'satuan_id')->dropDownList($DataSatuan, ['prompt' => '- Pilih Satuan -'])->label('Satuan') ?>

    <?= $form->field($model, 'produsen_id')->dropDownList($DataProdusen, ['prompt' => '- Pilih Produsen -'])->label('Produsen') ?>

    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    <?= $form->field($model, 'stok')->textInput() ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
