<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaReturnPembelian */

$this->title = 'Detail'. ' '. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ta Return Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ta-return-pembelian-view">
    <div class="box box-default">
        <div class="box-header">
            <p>
                <?= Html::a('Lihat Semua Data', ['index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Ubah Data', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'obat_id',
                    'jumlah',
                    'distributor_id',
                    'tanggal',
                    'waktu_entri',
                    'kd_user',
                    'status',
                ],
            ]) ?>
        </div>
    </div>
</div>
