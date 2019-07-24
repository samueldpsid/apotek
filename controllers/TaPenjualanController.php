<?php

namespace app\controllers;

use Yii;
use app\models\TaPenjualan;
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
class TaPenjualanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'id', // required
                'value' => 'PJ' . '-?' , 
                'digit' => 6 
            ],
        ];
    }

    /**
     * Lists all TaPenjualan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaPenjualanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);
        $dataProvider->query->limit(2);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaPenjualan model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TaPenjualan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        if ($session->has('obat')) {
            $obat = $session['obat'];
        }
        else {
            $obat = [];
        }

        // print_r($obat);die();

        $kdPJ = TaPenjualan::find()
                ->select('id')
                ->orderBy(['id' => SORT_DESC])
                ->limit(1)
                ->all();

        if (empty($kdPJ)) {
            $last_kdPJ = "PJ-000000";
        }
        else {
            $last_kdPJ = $kdPJ[0]['id'];
        }
        
        $kodePJ = substr($last_kdPJ, 3, 6);
        $kodePJ++;

        $modelObat = new \yii\base\DynamicModel(['kd_obat', 'qty', 'uang_bayar', 'uang_kembali', 'catatan', 'user', 'kd_penjualan', 'tanggal', 'stok']);
        $modelObat->addRule(['kd_obat', 'kd_penjualan'], 'string', ['max' => 128]);
        $modelObat->addRule(['catatan', 'user'], 'string', ['max' => 255]);
        $modelObat->addRule(['qty', 'stok'], 'integer');
        $modelObat->kd_penjualan = 'PJ-' . sprintf('%06s', $kodePJ);
        $modelObat->user = Yii::$app->user->identity->username;
        $modelObat->tanggal = date('d/m/Y');
        $modelObat->uang_kembali = 0;
        $modelObat->uang_bayar = 0;

        $searchModelObat = new RefObatSearch();
        $dataProviderObat = $searchModelObat->search(Yii::$app->request->queryParams);

        // $model = new TaPenjualan();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        return $this->render('create', [
            'modelObat' => $modelObat,
            'obat' => $obat,
            'searchModelObat' => $searchModelObat,
            'dataProviderObat' => $dataProviderObat,
        ]);
    }

    public function actionAddObat() 
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $modelObat = new \yii\base\DynamicModel(['kd_obat', 'qty']);
        $modelObat->addRule(['kd_obat', 'qty'], 'string', ['max' => 128]);
        $modelObat->load($request->post());

        if ($session->has('obat')) {
            $data = $session['obat'];
        }

        $data[$modelObat->kd_obat] = [
            'kd_obat' => $modelObat->kd_obat,
            'qty' => $modelObat->qty,
        ];
        
        $session['obat'] = $data;
    }

    public function actionRemoveObat($kd_obat) {
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        if ($session->has('obat')) {
            unset($_SESSION['obat'][$kd_obat]);
        }
    }

    public function actionSave($kd_penjualan, $grand_total) 
    {
        $session = Yii::$app->session;
        $obat = $session['obat'];

        $model = new TaPenjualan();
        $model->id = $kd_penjualan;
        $model->grand_total = $grand_total;
        $model->tanggal = date('Y-m-d');
        $model->waktu_entri = time();
        $model->kd_user = Yii::$app->user->identity->id;
        if ($model->save()) {
            foreach ($obat as $key => $value) {
                $data = RefObat::find()->where(['id'=>$value['kd_obat']])->one();

                $modelObat = new TaDetailPenjualan();
                $modelObat->penjualan_id = $kd_penjualan;
                $modelObat->obat_id = $value['kd_obat'];
                $modelObat->jumlah = $value['qty'];
                $modelObat->sub_total = $data->harga_jual * $value['qty'];

                $stokObat = RefObat::find()->where(['id'=>$value['kd_obat']])->one();
                $stokObat->stok -= $modelObat->jumlah;
                $stokObat->save();

                if ($modelObat->save()) {
                    $stokObat = RefObat::find()->where(['id'=>$value['kd_obat']])->one();
                    $stokObat->stok -= $modelObat->jumlah;
                    $stokObat->save();
                    unset($_SESSION['obat']);
                }
            }
        }
    }

    public function actionCetakPenjualan($kd_penjualan, $uang_bayar, $uang_kembali, $grand_total) {

        $session = Yii::$app->session;
        $obat = $session['obat'];
        $model = TaDetailPenjualan::find()->where(['penjualan_id' => $kd_penjualan])->all();

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

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'format' => Pdf::FORMAT_A4,
            'content' => $this->renderPartial('penjualan-cetak', ['model' => $model, 'kd_penjualan' => $kd_penjualan, 'grand_total' => $grand_total, 'uang_bayar' => $uang_bayar, 'uang_kembali' => $uang_kembali]),
            'options' => [
                'title' => '',
            //'subject' => 'Generating PDF files via yii2-mpdf extension has never been easy'
            ],
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'options' => [
                'title' => 'Laporan Penjualan',
            ],
            'methods' => [
                'SetHeader' => ['Invoice ||' . (date('d/m/Y'))],
                // 'SetFooter' => ['|Halaman {PAGENO}|'],
            ],
            // ],
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Laporan Penjualan',
        ]);
        return $pdf->render();
    }

    /**
     * Updates an existing TaPenjualan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TaPenjualan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaPenjualan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TaPenjualan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaPenjualan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
