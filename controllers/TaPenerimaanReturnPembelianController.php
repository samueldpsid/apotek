<?php

namespace app\controllers;

use Yii;
use app\models\TaPenerimaanReturnPembelian;
use app\models\TaReturnPembelian;
use app\models\RefObat;
use app\models\search\TaPenerimaanReturnPembelianSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\search\TaReturnPembelianSearch;

/**
 * TaPenerimaanReturnPembelianController implements the CRUD actions for TaPenerimaanReturnPembelian model.
 */
class TaPenerimaanReturnPembelianController extends Controller
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
                'value' => 'PRPB-' . '?',
                'digit' => 6 
            ],
        ];
    }

    /**
     * Lists all TaPenerimaanReturnPembelian models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaPenerimaanReturnPembelianSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaPenerimaanReturnPembelian model.
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
     * Creates a new TaPenerimaanReturnPembelian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaPenerimaanReturnPembelian();
        $model->status = 0;

        $searchModelReturnPembelian = new TaReturnPembelianSearch();
        $dataProviderReturnPembelian = $searchModelReturnPembelian->search(Yii::$app->request->queryParams);
        $dataProviderReturnPembelian->query->where(['status' => '0']);

        $modelObat = new \yii\base\DynamicModel(['obat_id', 'nama_obat', 'jumlah', 'distributor_id']);
        $modelObat->addRule(['obat_id'], 'string', ['max' => 128]);
        $modelObat->addRule(['nama_obat'], 'string', ['max' => 255]);
        $modelObat->addRule(['jumlah', 'distributor_id'], 'integer');

        $DataDistributor = ArrayHelper::map(\app\models\RefDistributor::find()
                    ->orderBy(['distributor' => SORT_ASC])
                    ->asArray()
                    ->all(), 'id', 'distributor');

        if ($model->load(Yii::$app->request->post()) && $modelObat->load(Yii::$app->request->post())) {

            $stokObat = RefObat::find()->where(['id'=>$modelObat->obat_id])->one();
            $stokObat->stok += $modelObat->jumlah;
            $stokObat->save();

            if ($model->save()) {
                $data = TaReturnPembelian::find()->where(['id' => $model->return_pembelian_id])->one();
                $data->status = '1';
                $data->save();

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelObat' => $modelObat,
            'DataDistributor' => $DataDistributor,
            'searchModelReturnPembelian' => $searchModelReturnPembelian,
            'dataProviderReturnPembelian' => $dataProviderReturnPembelian,
        ]);
    }

    /**
     * Updates an existing TaPenerimaanReturnPembelian model.
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
     * Deletes an existing TaPenerimaanReturnPembelian model.
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
     * Finds the TaPenerimaanReturnPembelian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TaPenerimaanReturnPembelian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaPenerimaanReturnPembelian::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
