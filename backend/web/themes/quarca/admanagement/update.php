<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AdManagement */

$this->title = 'Update Ad Management: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ad Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ad-management-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
