<?php

namespace app\controllers;

use Yii;
use app\models\TaPembelian;
use app\models\search\TaPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RefObat;
use app\models\search\RefObatSearch;
use app\models\TaDetailPembelian;
use yii\helpers\ArrayHelper;

/**
 * TaPembelianController implements the CRUD actions for TaPembelian model.
 */
class TaPembelianController extends Controller
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
                'value' => 'PB' . '-?' , 
                'digit' => 6 
            ],
        ];
    }

    /**
     * Lists all TaPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->orderBy(['id' => SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaPembelian model.
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
     * Creates a new TaPembelian model.
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

        $kd_obat = TaPembelian::find()
                ->select('id')
                ->orderBy(['id' => SORT_DESC])
                ->limit(1)
                ->all();

        if (empty($kd_obat)) {
            $last_kd_obat = "PB-000000";
        }
        else {
            $last_kd_obat = $kd_obat[0]['id'];
        }
        
        $kdObat = substr($last_kd_obat, 3, 6);
        $kdObat++;

        $modelPembelian = new \yii\base\DynamicModel(['kd_obat', 'qty', 'uang_bayar', 'uang_kembali', 'catatan', 'kd_pembelian', 'tanggal', 'nama_obat', 'distributor_id', 'harga_beli']);
        $modelPembelian->addRule(['kd_obat', 'kd_pembelian'], 'string', ['max' => 128]);
        $modelPembelian->addRule(['catatan', 'nama_obat'], 'string', ['max' => 255]);
        $modelPembelian->addRule(['qty', 'distributor_id', 'harga_beli'], 'integer');
        $modelPembelian->kd_pembelian = 'PB-' . sprintf('%06s', $kdObat);
        $modelPembelian->tanggal = date('d/m/Y');
        $modelPembelian->uang_kembali = 0;

        $searchModelObat = new RefObatSearch();
        $dataProviderObat = $searchModelObat->search(Yii::$app->request->queryParams);

        $DataDistributor = ArrayHelper::map(\app\models\RefDistributor::find()
                    ->orderBy(['distributor' => SORT_ASC])
                    ->asArray()
                    ->all(), 'id', 'distributor');

        // $model = new TaPembelian();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        return $this->render('create', [
            'modelPembelian' => $modelPembelian,
            'obat' => $obat,
            'searchModelObat' => $searchModelObat,
            'dataProviderObat' => $dataProviderObat,
            'DataDistributor' => $DataDistributor,
        ]);
    }

    public function actionSave($kd_pembelian, $grand_total, $kd_distributor) 
    {
        $session = Yii::$app->session;
        $obat = $session['obat'];

        $model = new TaPembelian();
        $model->id              = $kd_pembelian;
        $model->distributor_id  = $kd_distributor;
        $model->grand_total     = $grand_total;
        $model->tanggal         = date('Y-m-d');
        $model->waktu_entri     = time();
        $model->kd_user         = Yii::$app->user->identity->id;

        if ($model->save()) {
            foreach ($obat as $key => $value) {
                $data = RefObat::find()->where(['id'=>$value['kd_obat']])->one();

                $modelPembelian = new TaDetailPembelian();
                $modelPembelian->pembelian_id = $kd_pembelian;
                $modelPembelian->obat_id = $value['kd_obat'];
                $modelPembelian->jumlah = $value['qty'];
                $modelPembelian->sub_total = $data->harga_beli * $value['qty'];

                $stokObat = RefObat::find()->where(['id'=>$value['kd_obat']])->one();
                $stokObat->stok += $modelPembelian->jumlah;
                $stokObat->save();

                if ($modelPembelian->save()) {
                    unset($_SESSION['obat']);
                }
            }
        }
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

    /**
     * Updates an existing TaPembelian model.
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
     * Deletes an existing TaPembelian model.
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
     * Finds the TaPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TaPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
