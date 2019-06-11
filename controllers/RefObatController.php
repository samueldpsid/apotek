<?php

namespace app\controllers;

use Yii;
use app\models\RefObat;
use app\models\search\RefObatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * RefObatController implements the CRUD actions for RefObat model.
 */
class RefObatController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kd_obat', // required
                'value' => 'OB' . '-?' , 
                'digit' => 4 
            ]
        ];
    }

    /**
     * Lists all RefObat models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new RefObatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single RefObat model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "RefObat #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new RefObat model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new RefObat();

        $kode = RefObat::find()
                ->select('id')
                ->orderBy(['id' => SORT_DESC])
                ->limit(1)
                ->all();

        if (empty($kode)) {
            $last_kode = "OB-0000";
        }
        else {
            $last_kode = $kode[0]['id'];
        }
        
        $str_kode = substr($last_kode, 3, 4);
        $str_kode++;

        $modelObat = new \yii\base\DynamicModel(['kd_obat']);
        $modelObat->addRule(['kd_obat'], 'string', ['max' => 128]);
        $modelObat->kd_obat = 'OB-' . sprintf('%04s', $str_kode);

        $DataProdusen = ArrayHelper::map(\app\models\RefProdusen::find()
            ->orderBy(['produsen' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'produsen');

        $DataKategori = ArrayHelper::map(\app\models\RefKategori::find()
            ->orderBy(['kategori' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'kategori');

        $DataSatuan = ArrayHelper::map(\app\models\RefSatuan::find()
            ->orderBy(['satuan' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'satuan');  

        if($request->isAjax){
            $model->id = $modelObat->kd_obat;
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Tambah Data Obat",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'modelObat' => $modelObat,
                        'DataProdusen' => $DataProdusen,
                        'DataKategori' => $DataKategori,
                        'DataSatuan' => $DataSatuan,
                    ]),
                    'footer'=> Html::button('Tutup',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                                Html::button('Simpan',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Tambah Data Obat",
                    'content'=>'<span class="text-success">Berhasil Tambah Obat</span>',
                    'footer'=> Html::button('Tutup',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                            Html::a('Tambah Obat Baru',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Tambah Data Obat",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'modelObat' => $modelObat,
                        'DataProdusen' => $DataProdusen,
                        'DataKategori' => $DataKategori,
                        'DataSatuan' => $DataSatuan,
                    ]),
                    'footer'=> Html::button('Tutup',['class'=>'btn btn-danger pull-left','data-dismiss'=>"modal"]).
                                Html::button('Simpan',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'modelObat' => $modelObat,
                    'DataProdusen' => $DataProdusen,
                    'DataKategori' => $DataKategori,
                    'DataSatuan' => $DataSatuan,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing RefObat model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $DataProdusen = ArrayHelper::map(\app\models\RefProdusen::find()
            ->orderBy(['produsen' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'produsen');

        $DataKategori = ArrayHelper::map(\app\models\RefKategori::find()
            ->orderBy(['kategori' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'kategori');

        $DataSatuan = ArrayHelper::map(\app\models\RefSatuan::find()
            ->orderBy(['satuan' => SORT_ASC])
            ->asArray()
            ->all(), 'id', 'satuan');       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update RefObat #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'DataProdusen' => $DataProdusen,
                        'DataKategori' => $DataKategori,
                        'DataSatuan' => $DataSatuan,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "RefObat #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'DataProdusen' => $DataProdusen,
                        'DataKategori' => $DataKategori,
                        'DataSatuan' => $DataSatuan,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update RefObat #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'DataProdusen' => $DataProdusen,
                        'DataKategori' => $DataKategori,
                        'DataSatuan' => $DataSatuan,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'DataProdusen' => $DataProdusen,
                    'DataKategori' => $DataKategori,
                    'DataSatuan' => $DataSatuan,
                ]);
            }
        }
    }

    /**
     * Delete an existing RefObat model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing RefObat model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the RefObat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RefObat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RefObat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
