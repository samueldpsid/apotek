
<?php $no=1; foreach ($data as $value1): ?>   
    <tr>
        <td style="width: 10px; text-align: center;"><?= $no++ ?></td>
        <td colspan="2" style="text-align: center;"><b><?= $value1->id ?></b></td>
        <td colspan="3" style="text-align: center;"><b><?= date("d-m-Y", strtotime($value1->tanggal)) ?></b></td>
        <td style="text-align:right;"><b><?php echo number_format($value1->grand_total, 0, ',', '.') ?></b></td>
    </tr>
    <!-- <tr>
        <th></th>
        <th style="text-align:center;">Kode Obat</th>
        <th style="text-align:center;">Nama Obat</th>
        <th style="text-align:center;">Jumlah</th>
        <th style="text-align:center;">Satuan</th>
        <th style="text-align:center;">Harga</th>
        <th style="text-align:center;">Sub Total (Rp)</th>
    </tr> -->
    <?php foreach ($value1->taDetailPenjualans as $value2): ?>
        <tr>
            <td></td>
            <td style="padding-left:10px;"><?= $value2->obat_id ?></td>
            <td style="padding-left:10px;"><?= $value2->obat->nama_obat ?></td>
            <td style="text-align: center;"><?= $value2->jumlah ?></td>
            <td style="text-align: center;"><?= $value2->obat->satuan->satuan ?></td>
            <td style="text-align:right;"><?= number_format($value2->obat->harga_jual, 0, ',', '.'); ?></td>
            <td style="text-align:right;"><?= number_format($value2->sub_total, 0, ',', '.'); ?></td>
        </tr>
    <?php endforeach; ?>
<?php endforeach; ?>