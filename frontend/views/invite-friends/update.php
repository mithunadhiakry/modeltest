<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\InviteFriends */

$this->title = 'Update Invite Friends: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invite Friends', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="invite-friends-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
