<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RefProdusen */
?>
<div class="ref-produsen-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'produsen',
        ],
    ]) ?>

</div>
