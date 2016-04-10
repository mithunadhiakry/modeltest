<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdPosition */

$this->title = 'Update Ad Position: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ad Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ad-position-update">


    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
