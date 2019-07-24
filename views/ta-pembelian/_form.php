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
        var harga_beli = $(this).data('beli');

        $('#kd_obat').val(kd_obat);
        $('#nama_obat').val(nama_obat);
        $('#harga_beli').val(harga_beli);
    });

    $(document).on('click', '#btn-add', function(e){
        e.preventDefault();

        var kd_obat = $('#kd_obat').val();
        var qty = $('#qty').val();

        if (kd_obat == '' || qty == '') {
            alert ('Silahkan Pilih Obat dan Masukkan Jumlah !');
        }
        else {
            $.post('".Url::to(['add-obat'])."', $('#form-add').serialize(), function(data) {
                // alert(data);
                $.pjax.reload({container: '#table-session', async: false});
            });

            $('#kd_obat').val('');
            $('#nama_obat').val('');
            $('#qty').val('');
            $('#harga_beli').val('');
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
        
    });

    $(document).on('click', '#btn-simpan', function(e){
        e.preventDefault();
        
        var kd_pembelian = $('#kd_pembelian').val();
        var kd_distributor = $('#kd_distributor').val();
        var grand_total = $('#uang-total').val();

        if (kd_distributor == '') {
            alert ('Silahkan Pilih Distributor !');
        }
        else {
            $.ajax({ 
                type: 'GET',
                url:'index.php?r=ta-pembelian/save',
                data:{kd_pembelian : kd_pembelian, grand_total : grand_total, kd_distributor : kd_distributor},
                success: function(data){
                    window.location.href = '".Url::to(['create'])."';
                    // alert(data);
                },
            });
        }
    });

");

/* @var $this yii\web\View */
/* @var $model app\models\TaPenjualan */
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
                    <h1 class="box-title"><i class="fa fa-info"></i> Data Obat</h1>
                </div>
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => ['id' => 'form-add'],
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
                        ]); 
                    ?>

                    <?php 
                        echo $form->field($modelPembelian, 'kd_obat', [
                            'addon' => [
                                'append' => [
                                    'content' => Html::button('<i class="fa fa-search"></i>', ['class'=>'btn btn-primary', 'data-pjax' => '0', 'data-toggle' => 'modal', 'data-target' => '#modal_obat']),
                                    'asButton' => true
                                ]
                            ],
                        ])->textInput(['id' => 'kd_obat', 'readOnly' => true])->label('Kode Obat'); 
                    ?>

                    <?= $form->field($modelPembelian, 'nama_obat')->textarea(['id' => 'nama_obat', 'rows' => '3', 'placeholder' => '', 'readOnly'=>true,])
                    ?>

                    <?= $form->field($modelPembelian, 'harga_beli')->textInput(['id'=>'harga_beli', 'maxlength'=>true, 'autocomplete'=>'off', 'readOnly'=>true])->label('Harga') ?>

                    <?= $form->field($modelPembelian, 'qty')->textInput(['id'=>'qty', 'maxlength'=>true, 'autocomplete'=>'off'])->label('Jumlah') ?>

                    <?= Html::button('<i class="fa fa-plus"></i> Tambah', ['class'=>'btn btn-block btn-flat btn-primary', 'id'=>'btn-add']) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-body">
                    <?php 
                        $form = ActiveForm::begin([
                            'options' => [],
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
                        ]); 
                    ?>
                    
                    <div class="col-md-6">
                        <?php 
                            echo $form->field($modelPembelian, 'kd_pembelian')
                            ->textInput(['id'=>'kd_pembelian', 'maxlength' => true, 'readOnly' => true])
                            ->label('No.Transaksi') 
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php 
                            echo $form->field($modelPembelian, 'tanggal')
                            ->textInput(['maxlength' => true, 'readOnly' => true])
                            ->label('Tanggal') 
                        ?>
                    </div>

                    <div class="col-md-6">
                        <?php echo $form->field($modelPembelian, 'distributor_id')->dropDownList($DataDistributor, ['prompt' => '- Pilih Distributor -', 'id'=>'kd_distributor'])->label('Distributor') ?>
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
                                <th style="text-align: center;">Jumlah</th>
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

                                    $subtotal = $data->harga_beli * $value['qty'];
                                    $total += $subtotal;
                                    ?>
                                        <tr>
                                            <td id="tbody" style="text-align: center;"><?= $data->id ?></td>
                                            <td id="tbody"><?= $data->nama_obat ?></td>
                                            <td id="tbody" style="text-align: right;"><?= $value['qty'] ?></td>
                                            <td id="tbody" style="text-align: right;"><?= number_format($data->harga_beli,0,",",".") ?></td>
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
                <div class="box-footer">
                    <div class="form-group">
                        <?= Html::button('<i class="fa fa-save"></i> Simpan Transaksi', ['class' => 'btn btn-flat btn-primary', 'id' => 'btn-simpan']) ?>
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