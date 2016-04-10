<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\NotificationList */

$this->title = 'Update Notification List: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Notification Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="notification-list-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
