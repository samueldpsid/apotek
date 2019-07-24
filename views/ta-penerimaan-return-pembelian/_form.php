<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaPenerimaanReturnPembelian */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
    $(document).on('click', '.btn-pilih', function(e){
        e.preventDefault();
        var return_pembelian_id = $(this).data('id');
        var obat_id = $(this).data('obat_id');
        var nama_obat = $(this).data('nama');
        var jumlah = $(this).data('jumlah');
        var distributor_id = $(this).data('distributor');

        $('#return_pembelian_id').val(return_pembelian_id);
        $('#obat_id').val(obat_id);
        $('#nama_obat').val(nama_obat);
        $('#jumlah').val(jumlah);
        $('#distributor_id').val(distributor_id);
    });
");

?>

<div class="ta-penerimaan-return-pembelian-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-md-6">
                        <?= $form->field($model, 'return_pembelian_id', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::button('<i class="fa fa-search"></i>', ['class'=>'btn btn-primary', 'data-pjax' => '0', 'data-toggle' => 'modal', 'data-target' => '#modal_obat']),
                                        'asButton' => true
                                    ]
                                ],
                            ])->textInput(['id' => 'return_pembelian_id', 'readOnly' => true])->label('No. Return Pembelian'); 
                        ?>

                        <?= $form->field($modelObat, 'obat_id')->textInput(['id' => 'obat_id', 'maxlength' => true, 'autocomplete' => 'off', 'readOnly'=>true])->label('Stok') ?>

                        <?= $form->field($modelObat, 'nama_obat')->textarea(['id' => 'nama_obat', 'rows' => '3', 'readOnly' => true])
                        ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($modelObat, 'jumlah')->textInput(['id'=>'jumlah', 'autocomplete'=>'off', 'readOnly' => true]) ?>

                        <?php echo $form->field($modelObat, 'distributor_id')->dropDownList($DataDistributor, ['prompt' => '- Pilih Distributor -', 'id'=>'distributor_id', 'disabled' => true])->label('Distributor') ?>

                        <div class="form-group">
                            <?php 
                                echo '<label class="control-label">Tanggal</label>';
                                echo DatePicker::widget([
                                    'model' => $model, 
                                    'attribute' => 'tanggal',
                                    'options' => ['placeholder' => 'Tanggal Transaksi', 'autocomplete'=>'off'],
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        // 'format' => 'dd/mm/yyyy'
                                        'format' => 'yyyy/mm/dd'
                                    ]
                                ]);
                            ?>
                        </div>

                        <div class="form-group">
                            <?= Html::submitButton('<i class="fa fa-save"></i> Simpan', ['class' => 'btn btn-flat btn-primary']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div> 
        </div>
    </div> 
</div>

<?= $this->render('daftar-return',[
    'dataProviderReturnPembelian' => $dataProviderReturnPembelian,
    'searchModelReturnPembelian' => $searchModelReturnPembelian,
]) ?>