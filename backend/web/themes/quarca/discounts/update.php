<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Discounts */

$this->title = 'Update Discounts: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="discounts-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
