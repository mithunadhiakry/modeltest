<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Chapter */

$this->title = 'Update Chapter: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chapters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chapter-update">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
