<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaReturnPembelian */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
    $(document).on('click', '.btn-pilih', function(e){
        e.preventDefault();
        var kd_obat = $(this).data('kode');
        var nama_obat = $(this).data('nama');
        var stok = $(this).data('stok');

        $('#kd_obat').val(kd_obat);
        $('#nama_obat').val(nama_obat);
        $('#stok').val(stok);
    });
");

?>

<div class="ta-return-pembelian-form">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="col-md-6">
                        <?= $form->field($model, 'obat_id', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::button('<i class="fa fa-search"></i>', ['class'=>'btn btn-primary', 'data-pjax' => '0', 'data-toggle' => 'modal', 'data-target' => '#modal_obat']),
                                        'asButton' => true
                                    ]
                                ],
                            ])->textInput(['id' => 'kd_obat', 'readOnly' => true])->label('Kode Obat'); 
                        ?>

                        <?= $form->field($modelReturnPembelian, 'nama_obat')->textarea(['id' => 'nama_obat', 'rows' => '3', 'readOnly'=>true])
                        ?>

                        <?= $form->field($modelReturnPembelian, 'stok')->textInput(['id'=>'stok', 'maxlength'=>true, 'autocomplete'=>'off', 'readOnly'=>true])->label('Stok') ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'jumlah')->textInput(['autocomplete'=>'off']) ?>

                        <?php echo $form->field($model, 'distributor_id')->dropDownList($DataDistributor, ['prompt' => '- Pilih Distributor -', 'id'=>'kd_distributor'])->label('Distributor') ?>

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


<?= $this->render('/ta-penjualan/daftar-obat',[
    'dataProviderObat' => $dataProviderObat,
    'searchModelObat' => $searchModelObat,
]) ?>