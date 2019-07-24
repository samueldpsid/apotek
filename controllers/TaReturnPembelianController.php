<?php

namespace app\controllers;

use Yii;
use app\models\TaReturnPembelian;
use app\models\search\TaReturnPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\search\RefObatSearch;
/**
 * TaReturnPembelianController implements the CRUD actions for TaReturnPembelian model.
 */
class TaReturnPembelianController extends Controller
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
                'value' => 'RPB-' . '?' , 
                'digit' => 6 
            ],
        ];
    }

    /**
     * Lists all TaReturnPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaReturnPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaReturnPembelian model.
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
     * Creates a new TaReturnPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaReturnPembelian();
        $model->kd_user = Yii::$app->user->identity->id;
        $model->waktu_entri = time();
        $model->status = '0';

        $searchModelObat = new RefObatSearch();
        $dataProviderObat = $searchModelObat->search(Yii::$app->request->queryParams);

        $DataDistributor = ArrayHelper::map(\app\models\RefDistributor::find()
                    ->orderBy(['distributor' => SORT_ASC])
                    ->asArray()
                    ->all(), 'id', 'distributor');

        $modelReturnPembelian = new \yii\base\DynamicModel(['nama_obat', 'stok']);
        $modelReturnPembelian->addRule(['catatan', 'nama_obat'], 'string', ['max' => 255]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Data berhasil disimpan");
            // return $this->redirect(['index']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'searchModelObat' => $searchModelObat,
            'dataProviderObat' => $dataProviderObat,
            'DataDistributor' => $DataDistributor,
            'modelReturnPembelian' => $modelReturnPembelian,
        ]);
    }

    /**
     * Updates an existing TaReturnPembelian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $searchModelObat = new RefObatSearch();
        $dataProviderObat = $searchModelObat->search(Yii::$app->request->queryParams);

        $DataDistributor = ArrayHelper::map(\app\models\RefDistributor::find()
                    ->orderBy(['distributor' => SORT_ASC])
                    ->asArray()
                    ->all(), 'id', 'distributor');

        $modelReturnPembelian = new \yii\base\DynamicModel(['nama_obat', 'stok']);
        $modelReturnPembelian->addRule(['catatan', 'nama_obat'], 'string', ['max' => 255]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'searchModelObat' => $searchModelObat,
            'dataProviderObat' => $dataProviderObat,
            'DataDistributor' => $DataDistributor,
            'modelReturnPembelian' => $modelReturnPembelian,
        ]);
    }

    /**
     * Deletes an existing TaReturnPembelian model.
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
     * Finds the TaReturnPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TaReturnPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaReturnPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
