<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PointTable */

$this->title = 'Update Point Table: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Point Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="point-table-update pane">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
