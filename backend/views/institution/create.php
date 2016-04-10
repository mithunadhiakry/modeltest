<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Institution */

$this->title = 'Create Institution';
$this->params['breadcrumbs'][] = ['label' => 'Institutions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="institution-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
