
<caption class="headerFox text-center">
    <h4><b>LAPORAN PENJUALAN</b></h4>
</caption>

<table width="100%" class="table table-bordered">
    <thead>
        <tr>
            <th style="text-align:center; font-size: 12px;">NO</th>
            <th colspan="2" style="text-align:center; font-size: 12px;">NO TRANSAKSI</th>
            <th colspan="3" style="text-align:center; font-size: 12px;">TANGGAL</th>
            <th style="text-align:center; font-size: 12px;">GRAND TOTAL (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($data as $value1): ?>   
            <tr>
                <td style="width: 10px; text-align: center; font-size: 12px;"><?= $no++ ?></td>
                <td colspan="2" style="text-align: center; font-size: 12px;"><b><?= $value1->id ?></b></td>
                <td colspan="3" style="text-align: center; font-size: 12px;"><b><?= date("d-m-Y", strtotime($value1->tanggal)) ?></b></td>
                <td style="text-align:right; font-size: 12px;"><b><?php echo number_format($value1->grand_total, 0, ',', '.') ?></b></td>
            </tr>
            <!-- <tr>
                <td></td>
                <td style="text-align:center;">Kode Obat</td>
                <td style="text-align:center;">Nama Obat</td>
                <td style="text-align:center;">Jumlah</td>
                <td style="text-align:center;">Satuan</td>
                <td style="text-align:center;">Harga</td>
                <td style="text-align:center;">Sub Total (Rp)</td>
            </tr> -->
            <?php
            foreach ($value1->taDetailPenjualans as $value2): ?>
                <tr>
                    <td></td>
                    <td style="padding-left:10px; font-size: 12px;"><?= $value2->obat_id ?></td>
                    <td style="padding-left:10px; font-size: 12px;"><?= $value2->obat->nama_obat ?></td>
                    <td style="text-align: center; font-size: 12px;"><?= $value2->jumlah ?></td>
                    <td style="text-align: center; font-size: 12px;"><?= $value2->obat->satuan->satuan ?></td>
                    <td style="text-align:right; font-size: 12px;"><?= number_format($value2->obat->harga_jual, 0, ',', '.'); ?></td>
                    <td style="text-align:right; font-size: 12px;"><?= number_format($value2->sub_total, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" style="font-size: 12px;"><b>TOTAL PENJUALAN</b></td>
            <td style="text-align: right; font-size: 12px;"><b>Rp <?= number_format($total,0,",",".") ?></b></td>
        </tr>
    </tfoot>
</table>