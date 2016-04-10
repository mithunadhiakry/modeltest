<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\InviteFriends */

$this->title = 'Create Invite Friends';
$this->params['breadcrumbs'][] = ['label' => 'Invite Friends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invite-friends-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
