<?php

namespace app\controllers;

use Yii;
use app\models\TaPenjualan;
use app\models\TaPembelian;
use app\models\search\TaPenjualanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RefObat;
use app\models\search\RefObatSearch;
use app\models\TaDetailPenjualan;
use kartik\mpdf\Pdf;

/**
 * TaPenjualanController implements the CRUD actions for TaPenjualan model.
 */
class LaporanController extends Controller
{

    public function actionPenjualan()
    {
        return $this->render('penjualan');
    }

    public function actionGetPenjualan($tgl_awal, $tgl_akhir) 
    {
        $awal = date('Y-m-d', strtotime($tgl_awal));
        $akhir = date('Y-m-d', strtotime($tgl_akhir));

        $data = TaPenjualan::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->all();

        return $this->renderpartial('data-penjualan', [
            'data' => $data,
        ]);
    }

    public function actionGetTotalPj($tgl_awal, $tgl_akhir) 
    {
        $awal = date('Y-m-d', strtotime($tgl_awal));
        $akhir = date('Y-m-d', strtotime($tgl_akhir));

        $total = TaPenjualan::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->sum('grand_total');

        return $this->renderpartial('data-total-penjualan', [
            'total' => $total,
        ]);
    }

    public function actionCetakPenjualanPdf($tgl_awal, $tgl_akhir)
    {
        $tanggal             = date('Y-m-d');
        $day                 = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $month = date('m', strtotime($tanggal));
        $monthList  = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        $Hari       = $dayList[$day];
        $Bulan      = $monthList[$month];

        $awal = date('Y-m-d', strtotime($tgl_awal));
        $akhir = date('Y-m-d', strtotime($tgl_akhir));

        $data = TaPenjualan::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->all();

        $total = TaPenjualan::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->sum('grand_total');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_A4,
            'content' => $this->renderPartial('laporan-penjualan-cetak', ['data' => $data, 'total' => $total]),
            'options' => [
                'title' => 'Cetak Tvc1c1',
            //'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
            ],
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'options' => [
                'title' => 'Laporan Penjualan',
            ],
            'methods' => [
                'SetHeader' => ['Dicetak dari: Aplikasi APotek ||Dicetak tanggal: ' .
                    $Hari .', '.
                    (date('d')).' '.
                    $Bulan .' '.
                    (date('Y')).'/'.
                    (date('H:i:s'))],
                'SetFooter' => ['|Halaman {PAGENO}|'],
            ],
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Laporan Penjualan',
        ]);
        return $pdf->render();
    }

    public function actionPembelian()
    {
        return $this->render('pembelian');
    }

    public function actionGetPembelian($tgl_awal, $tgl_akhir) 
    {
        $awal = date('Y-m-d', strtotime($tgl_awal));
        $akhir = date('Y-m-d', strtotime($tgl_akhir));

        $data = TaPembelian::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->all();

        return $this->renderpartial('data-pembelian', [
            'data' => $data,
        ]);
    }

    public function actionGetTotalPb($tgl_awal, $tgl_akhir) 
    {
        $awal = date('Y-m-d', strtotime($tgl_awal));
        $akhir = date('Y-m-d', strtotime($tgl_akhir));

        $total = TaPembelian::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->sum('grand_total');

        return $this->renderpartial('data-total-pembelian', [
            'total' => $total,
        ]);
    }

    public function actionCetakPembelianPdf($tgl_awal, $tgl_akhir)
    {
        $tanggal             = date('Y-m-d');
        $day                 = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $month = date('m', strtotime($tanggal));
        $monthList  = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        );
        $Hari       = $dayList[$day];
        $Bulan      = $monthList[$month];

        $awal = date('Y-m-d', strtotime($tgl_awal));
        $akhir = date('Y-m-d', strtotime($tgl_akhir));
        
        $data = TaPembelian::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->all();

        $total = TaPembelian::find()
                ->where(['between', 'tanggal', $awal, $akhir])
                ->sum('grand_total');

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_A4,
            'content' => $this->renderPartial('laporan-pembelian-cetak', ['data' => $data, 'total' => $total]),
            'options' => [
                'title' => 'Cetak Tvc1c1',
            //'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
            ],
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'options' => [
                'title' => 'Laporan Pembelian',
            ],
            'methods' => [
                'SetHeader' => ['Dicetak dari: Aplikasi APotek ||Dicetak tanggal: ' .
                    $Hari .', '.
                    (date('d')).' '.
                    $Bulan .' '.
                    (date('Y')).'/'.
                    (date('H:i:s'))],
                'SetFooter' => ['|Halaman {PAGENO}|'],
            ],
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Laporan Pembelian',
        ]);
        return $pdf->render();
    }
}
