<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use app\models\RefObat;
use yii\widgets\Pjax;
use yii\widgets\MaskedInput;

$this->registerJs("
    $(document).on('click', '.btn-pilih', function(e){
        e.preventDefault();
        var kd_obat = $(this).data('kode');
        var stok = $(this).data('stok');
        $('#kd_obat').val(kd_obat);
        $('#stok').val(stok);
    });

    $(document).on('click', '#btn-add', function(e){
        e.preventDefault();

        var kd_obat = $('#kd_obat').val();
        var qty = $('#qty').val();
        var stok = $('#stok').val();
        var sisa_stok = stok - qty;

        if (kd_obat == '' || qty == '') {
            alert ('Silahkan Pilih Obat dan Masukkan Jumlah !');
        }
        else {
            if(sisa_stok < 1) {
                alert('Maaf, Stok Obat tidak mencukupi !');
            }
            else {
                $.post('".Url::to(['add-obat'])."', $('#form-add').serialize(), function(data) {
                    // alert(data);
                    $.pjax.reload({container: '#table-session', async: false});
                });

                $('#kd_obat').val('');
                $('#stok').val('');
                $('#qty').val('');
            }
        } 
    });

    $(document).on('click', '.btn-remove', function(e){
        e.preventDefault();

        var kd_obat = $(this).attr('id');

        $.ajax({ 
            type: 'GET',
            url:'index.php?r=ta-penjualan/remove-obat',
            data:{kd_obat : kd_obat},
            success: function(data){
                // alert(data);
                $.pjax.reload({container: '#table-session', async: false});
            },
        });
    });

    $('#uang-bayar').blur(function() {
        var total = $('#uang-total').val();
        var bayar = $('#uang-bayar').val();
        var bayar2 = parseFloat(bayar.replace(/[\,]/g,''));

        var kembali = bayar2 - total;
        var kembali2 = kembali.toFixed(0);
        var kembali3 = kembali2.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');

        $('#uang-kembali').val(kembali3);

        $('#uang_bayar').val(bayar2);
        $('#uang_kembali').val(kembali);
        
    });

    $(document).on('click', '#btn-simpan', function(e){
        e.preventDefault();
        
        var kd_penjualan = $('#kd_penjualan').val();
        var grand_total = $('#uang-total').val();
        var uang_bayar = $('#uang_bayar').val();
        var uang_kembali = $('#uang_kembali').val();

        $.ajax({ 
            type: 'GET',
            url:'index.php?r=ta-penjualan/save',
            data:{kd_penjualan : kd_penjualan, grand_total : grand_total},
            success: function(data){
                window.open('index.php?r=ta-penjualan%2Fcetak-penjualan&uang_bayar=' + uang_bayar + '&uang_kembali=' + uang_kembali + '&grand_total=' + grand_total + '&kd_penjualan=' + kd_penjualan, '_blank');
                window.location.href = '".Url::to(['create'])."';
                // alert(data);
            },
        });
    });

");

/* @var $this yii\web\View */
/* @var $model backend\models\TaPenjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    #tbody {
        vertical-align: middle;
        font-size: 14px;
        padding: 5px;
    }
</style>

<div class="ta-penjualan-form">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info"></i> Info Struk</h3>
                </div>
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => [],
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
                        ]); 
                    ?>

                    <?php 
                        echo $form->field($modelObat, 'kd_penjualan')
                        ->textInput(['id'=>'kd_penjualan', 'maxlength' => true, 'readOnly' => true])
                        ->label('No.Bukti') 
                    ?>

                    <?= $form->field($modelObat, 'user')
                        ->textInput(['maxlength' => true, 'readOnly' => true])
                        ->label('Kasir') 
                    ?>

                    <?= $form->field($modelObat, 'tanggal')
                        ->textInput(['maxlength' => true, 'readOnly' => true])
                        ->label('Tanggal') 
                    ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => ['id' => 'form-add'],
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
                        ]); 
                    ?>
                    <div class="col-md-5">
                        <?php 
                            echo $form->field($modelObat, 'kd_obat', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::button('<i class="fa fa-search"></i>', ['class'=>'btn btn-primary', 'data-pjax' => '0', 'data-toggle' => 'modal', 'data-target' => '#modal_obat']),
                                        'asButton' => true
                                    ]
                                ],
                            ])->textInput(['id' => 'kd_obat', 'readOnly' => true])->label('Kode Obat'); 
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($modelObat, 'stok')->textInput(['id'=>'stok', 'maxlength'=>true, 'autocomplete'=>'off', 'readOnly'=>true])->label('Stok') ?>
                    </div>
                    <div class="col-md-3">
                        <?= $form->field($modelObat, 'qty')->textInput(['id'=>'qty', 'maxlength'=>true, 'autocomplete'=>'off'])->label('Jumlah') ?>
                    </div>
                    
                    <?= Html::button('<i class="fa fa-plus"></i> Add', ['class'=>'btn btn-primary pull-right', 'id'=>'btn-add']) ?>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="box-body">
                    <?php Pjax::begin(['id'=>'table-session']) ?>   
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th style="text-align: center;">Kode</th>
                                <th style="width: 400px; text-align: center;">Nama Obat</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: center;">Harga</th>
                                <th style="text-align: center;">Sub Total</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                            <?php
                                $no = 1;
                                $total = 0;
                                if (isset($obat)) {
                                    // print_r($obat);
                                    foreach ($obat as $key => $value):
                                    $data = RefObat::find()->where(['id'=>$value['kd_obat']])->one();

                                    $subtotal = $data->harga_jual * $value['qty'];
                                    $total += $subtotal;
                                    ?>
                                        <tr>
                                            <td id="tbody" style="text-align: center;"><?= $data->id ?></td>
                                            <td id="tbody"><?= $data->nama_obat ?></td>
                                            <td id="tbody" style="text-align: right;"><?= $value['qty'] ?></td>
                                            <td id="tbody" style="text-align: right;"><?= number_format($data->harga_jual,0,",",".") ?></td>
                                            <td id="tbody" style="text-align: right;"><?= number_format($subtotal,0,",",".") ?></td>
                                            <td id="tbody" style="text-align: center;"><button class="btn btn-small btn-danger btn-remove" id="<?= $data->id ?>"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                    <?php endforeach;
                                }
                                else {
                                    echo "No data";
                                } 
                            ?>
                            
                        </tbody>
                    </table>
                    <input type="text" hidden="true" id="uang-total" value="<?= $total ?>">
                    <h1 class="pull-right" style="margin-top: 0px;"><b><?= number_format($total,0,",",",") ?></b></h1>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            
        </div>
        <div class="col-md-8">
            
        
            <div class="box box-default">
                <div class="box-body">
                    <div class="col-md-6">
                        <?= $form->field($modelObat, 'catatan')->textarea(['id' => 'catatan', 'rows' => '4', 'placeholder' => 'Tambahkan catatan'])
                        ?>
                    </div>

                    <div class="col-md-6">
                        <?php 
                            $form = ActiveForm::begin([
                                'options' => [],
                                'type' => ActiveForm::TYPE_HORIZONTAL,
                                'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
                            ]); 
                        ?>

                            <?= $form->field($modelObat, 'uang_bayar')
                                ->widget(\yii\widgets\MaskedInput::className(), [
                                    'options' => ['id' => 'uang-bayar', 'style'=> 'text-align: right; font-weight: 600;'],
                                    'clientOptions' => [
                                        'alias' => 'numeric',
                                        'radixPoint' => '.',
                                        'groupSeparator' => ',',
                                        'removeMaskOnSubmit' => true,
                                        'autoGroup' => true
                                    ],
                                ])->label('Bayar')
                            ?>

                            <?= $form->field($modelObat, 'uang_kembali')
                                ->textInput(['id' => 'uang-kembali', 'style'=> 'text-align:right; font-weight: 600', 'readOnly' => 'true'])
                                ->label('Kembali')
                            ?>

                            <input type="text" hidden="true" id="uang_bayar">
                            <input type="text" hidden="true" id="uang_kembali">
        
                        <?php ActiveForm::end(); ?>
                    </div>
                <div class="box-footer">
                    <div class="form-group">
                        <?= Html::button('<i class="fa fa-send"></i> Proses Pembayaran', ['class' => 'btn btn-flat btn-primary pull-right', 'id' => 'btn-simpan']) ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('daftar-obat',[
    'dataProviderObat' => $dataProviderObat,
    'searchModelObat' => $searchModelObat,
]) ?>