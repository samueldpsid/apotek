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
        var nama_obat = $(this).data('nama');
        var stok = $(this).data('stok');

        $('#kd_obat').val(kd_obat);
        $('#nama_obat').val(nama_obat);
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

        if(grand_total == 0) {
            alert('Data tidak tersedia!');
        }
        else if (uang_kembali <= 0) {
            alert('Silahkan Isi Jumlah Pembayaran Dengan Benar !');
        }
        else {
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
        }
    });

");

/* @var $this yii\web\View */
/* @var $model backend\models\TaPenjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<style type="text/css">
    #tbody {
        vertical-align: middle;
        font-size: 12px;
        /*padding: 5px;*/
        /*font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;*/
    }
</style>

<div class="ta-penjualan-form">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-info"></i> Info Struk</h3>
                </div>
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => [],
                            'type' => ActiveForm::TYPE_VERTICAL,
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
        
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => ['id' => 'form-add'],
                            // 'type' => ActiveForm::TYPE_HORIZONTAL,
                            // 'formConfig' => ['labelSpan' => 12, 'deviceSize' => ActiveForm::SIZE_SMALL]
                        ]); 
                    ?>
                    <div class="row">
                        <div class="col-sm-7">
                            <?php 
                                echo $form->field($modelObat, 'nama_obat', [
                                    'addon' => [
                                        'append' => [
                                            'content' => Html::button('<i class="fa fa-search"></i>', ['class'=>'btn btn-flat btn-primary', 'data-pjax' => '0', 'data-toggle' => 'modal', 'data-target' => '#modal_obat']),
                                            'asButton' => true
                                        ]
                                    ],
                                ])->textInput(['id' => 'nama_obat', 'readOnly' => true, 'placeholder' => 'Pilih Obat'])->label(false); 
                            ?>
                            <?= $form->field($modelObat, 'kd_obat')->hiddenInput(['id'=>'kd_obat', 'maxlength'=>true, 'autocomplete'=>'off'])->label(false) ?>
                        </div>
                        <div class="col-md-3">
                            <div class="col-sm-3">
                                <h5><b>Stok</b></h5>
                            </div>
                            <div class="col-sm-9">
                                <?= $form->field($modelObat, 'stok')->textInput(['id'=>'stok', 'maxlength'=>true, 'autocomplete'=>'off', 'readOnly'=>true])->label(false) ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="col-sm-3">
                                <h5><b>Qty</b></h5>
                            </div>
                            <div class="col-sm-9">
                                <?= $form->field($modelObat, 'qty')->textInput(['id'=>'qty', 'maxlength'=>true, 'autocomplete'=>'off'])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?= Html::button('<i class="fa fa-cart-plus"></i> Add to List', ['class'=>'btn btn-flat btn-primary', 'id'=>'btn-add']) ?>
                        </div>
                        
                    </div>
                    

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
        <div class="col-md-3">
        </div>
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => [],
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
                        ]); 
                    ?>
                    <div class="col-sm-6">
                        
                    </div>
                    <div class="col-sm-6">
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
                    </div>
                    <?php ActiveForm::end(); ?>
                    <div class="col-sm-6">
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?= Html::button('<i class="fa fa-send"></i> Proses Pembayaran', ['class' => 'btn btn-flat btn-success pull-right', 'id' => 'btn-simpan']) ?>
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