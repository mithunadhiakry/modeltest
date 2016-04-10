<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Institution */

$this->title = 'Update Institution: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Institutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="institution-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
