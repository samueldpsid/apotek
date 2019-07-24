<?php
	use app\models\RefObat;
?>

<caption class="headerFox text-center">
    <h4><b>Aplikasi Apotek</b></h4>
</caption>

<table>
	<thead>
		<tr>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="font-size: 12px">No Pesanan</td>
			<td style="font-size: 12px">:</td>
			<td style="font-size: 12px"><?= $kd_penjualan ?></td>
		</tr>
		<tr>
			<td style="font-size: 12px">Kasir</td>
			<td style="font-size: 12px">:</td>
			<td style="font-size: 12px"><?= Yii::$app->user->identity->nama ?></td>
		</tr>
		<tr>
			<td style="font-size: 12px">Waktu</td>
			<td style="font-size: 12px">:</td>
			<td style="font-size: 12px"><?= date('d-m-Y') .' '. date('H:i:s') ?></td>
		</tr>
	</tbody>
</table>

<br>

<table width="100%" class="table">
    <thead>
        <tr style="border: 0px;">
            <th style="text-align:left; font-size: 12px;">Nama Obat</th>
            <th style="text-align:center; font-size: 12px;">Qty</th>
            <th style="text-align:right; font-size: 12px;">Harga</th>
            <th style="text-align:right; font-size: 12px;">Sub Total</th>
        </tr>
    </thead>
    <tbody>   
        <?php
            $total = 0;
            if (isset($model)) {
                // print_r($model);
                foreach ($model as $key => $value):
                $data = RefObat::find()->where(['id'=>$value['obat_id']])->one();

                $subtotal = $data->harga_jual * $value['jumlah'];
                ?>
                    <tr>
                        <td id="tbody" style="font-size: 12px;"><?= $data->nama_obat ?></td>
                        <td id="tbody" style="text-align: center; font-size: 12px"><?= $value['jumlah'] ?></td>
                        <td id="tbody" style="text-align: right; font-size: 12px"><?= number_format($data->harga_jual,0,",",".") ?></td>
                        <td id="tbody" style="text-align: right; font-size: 12px"><?= number_format($subtotal,0,",",".") ?></td>
                    </tr>
                <?php endforeach;
            } 
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="font-size: 12px;"><b>Grand Total</b></td>
            <td style="text-align: right; font-size: 12px;"><?= number_format($grand_total,0,",",".") ?></td>
        </tr>
        <tr style="border: 0px;">
            <td colspan="3" style="font-size: 12px;"><b>Bayar</b></td>
            <td style="text-align: right; font-size: 12px;"><?= number_format($uang_bayar,0,",",".") ?></td>
        </tr>
        <tr>
            <td colspan="3" style="font-size: 12px; border-bottom: 1px solid #ddd; border-top: 0px;"><b>Kembali</b></td>
            <td style="text-align: right; font-size: 12px; border-bottom: 1px solid #ddd; border-top: 0px"><?= number_format($uang_kembali,0,",",".") ?></td>
        </tr>
    </tfoot>
</table>

<h5 style="text-align: center;">Terima Kasih ^_^</h5>