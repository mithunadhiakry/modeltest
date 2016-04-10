<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Countrycategoryrel */

$this->title = 'Update Countrycategoryrel: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Countrycategoryrels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="countrycategoryrel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
