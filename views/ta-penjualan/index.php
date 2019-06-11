<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TaPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penjualan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-penjualan-index">
    <div class="box box-default">
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('<i class="fa fa-plus"></i> Penjualan Baru', ['create'], ['class' => 'btn btn-flat btn-primary']) ?>
            </p>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'kartik\grid\ExpandRowColumn',
                        'value' => function ($model) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function($model){
                            return Yii::$app->controller->renderpartial('detail-penjualan',[
                                    'model' => $model,
                                ]);
                        }
                    ],
                    'id',
                    [
                        'attribute' => 'tanggal',
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:right;'
                        ],
                    ],
                    [   
                        'label' => 'Grand Total',
                        'value' => function($model) {
                        return number_format($model->grand_total, 0,",",".");
                        },
                        'contentOptions' => [
                            'style' => 'white-space:normal; text-align:right; font-weight:600;'
                        ],
                    ],
                    // ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}'],
                ],
            ]); ?>
        </div>
    </div>
</div>
