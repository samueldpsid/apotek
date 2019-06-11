<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TaPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Penjualan';
$this->params['breadcrumbs'][] = $this->title;

$jsCariPenjualan = "
    $('#btn-cari').on('click', function () {
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();

        if(tgl_awal == '' || tgl_akhir == '') {
            alert('Harap isi periode tanggal !');
        }
        else {
            $('#data_pj').html('<h4>Loading...</h4>');

            $.ajax({ 
                type:'GET',
                url:'index.php?r=laporan%2Fget-penjualan',
                data:{tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
                success: function(isi){
                    $('#data_pj').html(isi);
                },
                error: function(){
                    alert('Failure');
                }
            });
        }         
    });
";
$this->registerJs($jsCariPenjualan);

$JsTotal = "
    $('#btn-cari').on('click', function () {
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();

        $.ajax({ 
            type:'GET',
            url:'index.php?r=laporan%2Fget-total-pj',
            data:{tgl_awal:tgl_awal, tgl_akhir:tgl_akhir},
            success: function(isi){
                $('#total_pj').html(isi);
            },
            error: function(){
                alert('Failure');
            }
        });       
    });
";
$this->registerJs($JsTotal);

$jsCetakPenjualanPdf = "
    $('#btn-cetak-pdf').on('click', function () {
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();

        if(tgl_awal == '' || tgl_akhir == '') {
            alert('Harap isi periode tanggal !');
        }
        else {
            window.open('index.php?r=laporan%2Fcetak-penjualan-pdf&tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir, '_blank');
        }    
    });
";
$this->registerJs($jsCetakPenjualanPdf);

?>

<style type="text/css">
    table {
        font-size: 12px;
    }
</style>

<div class="ta-penjualan-index">
    <div class="box box-default">
        <div class="box-header">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <div class="row">
                <div class="col-md-1" style="text-align: center;">
                    <label style="margin-top: 8px;">Periode</label>
                </div>
                <div class="col-md-4">
                    <?php  
                        echo DatePicker::widget([
                            'name' => 'start_date', 
                            // 'value' => date('d-M-Y', strtotime('+2 days')),
                            'options' => ['placeholder' => 'Pilih tanggal ...', 'id' => 'tgl_awal', 'autocomplete'=>'off'],
                            'pluginOptions' => [
                                'format' => 'd-mm-yyyy',
                                'todayHighlight' => true
                            ]
                        ]);
                    ?>
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <label style="margin-top: 8px;">s/d</label>
                </div>
                <div class="col-md-4">
                    <?php  
                        echo DatePicker::widget([
                            'name' => 'end_date', 
                            // 'value' => date('d-M-Y', strtotime('+2 days')),
                            'options' => ['placeholder' => 'Pilih tanggal ...', 'id' => 'tgl_akhir', 'autocomplete'=>'off'],
                            'pluginOptions' => [
                                'format' => 'd-mm-yyyy',
                                'todayHighlight' => true
                            ]
                        ]);
                    ?>
                </div>
                <div class="col-md-1">
                    <?php
                        echo Html::Button('<i class="glyphicon glyphicon-search"></i> Cari', ['class' => 'btn btn-flat btn-primary', 'id' => 'btn-cari']) 
                    ?>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?php echo Html::Button('<i class="fa fa-print"></i> Preview Laporan', ['class' => 'btn btn-flat btn-primary', 'id' => 'btn-cetak-pdf']) ?>
                    </p>

                    <table width="100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center;">NO</th>
                                <th colspan="2" style="text-align:center;">NO TRANSAKSI</th>
                                <th colspan="3" style="text-align:center;">TANGGAL</th>
                                <th style="text-align:center;">GRAND TOTAL (Rp)</th>
                            </tr>
                        </thead>
                        <tbody id="data_pj">
                            
                        </tbody>
                        <tfoot id="total_pj">
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
