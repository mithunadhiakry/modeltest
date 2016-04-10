<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Membershiprequest */

$this->title = 'Update Membershiprequest: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Membershiprequests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="membershiprequest-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
