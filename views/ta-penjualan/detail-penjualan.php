<?php

use yii\helpers\Html;
?>

<style type="text/css">
	.table-data {
		border-collapse: collapse;
	    width: 100%;
	    border: 1px solid #000;
	}
	th{
	    border: 1px solid #000;
	    text-align: center;
	    padding: 0 5px;
	}
	td{
	    border-left: 1px solid #000;
	    border-right: 1px solid #000;
	    padding: 0 5px;
	}
</style>

<table class="table-data">
	<thead>
		<tr>
			<th>Kode Obat</th>
			<th>Nama Obat</th>
			<th>Jumlah</th>
			<th>Satuan</th>
			<th>Harga</th>
			<th>Sub Total</th>
		</tr>
	</thead>

	<tbody>
		<?php
			$data = $model->getTaDetailPenjualans()->all();
			foreach ($data as $value) : ?>
				<tr>
					<td><?= $value->obat_id ?></td>
					<td><?= $value->obat->nama_obat ?></td>
					<td style="text-align: center;"><?= $value->jumlah ?></td>
					<td style="text-align: center;"><?= $value->obat->satuan->satuan ?></td>
					<td style="text-align: right;"><?= number_format($value->obat->harga_jual, 0,",",".") ?></td>
					<td style="text-align: right;"><?= number_format($value->sub_total, 0,",",".") ?></td>
				</tr>
			<?php endforeach ;
		?>
	</tbody>
</table>