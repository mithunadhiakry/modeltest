<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserFront */

$this->title = 'Create User Front';
$this->params['breadcrumbs'][] = ['label' => 'User Fronts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-front-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
