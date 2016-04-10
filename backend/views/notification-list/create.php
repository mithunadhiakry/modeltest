<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\NotificationList */

$this->title = 'Create Notification List';
$this->params['breadcrumbs'][] = ['label' => 'Notification Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
