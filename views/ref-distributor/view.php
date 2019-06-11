<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RefDistributor */
?>
<div class="ref-distributor-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'distributor',
        ],
    ]) ?>

</div>
