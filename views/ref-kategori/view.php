<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RefKategori */
?>
<div class="ref-kategori-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kategori',
        ],
    ]) ?>

</div>
