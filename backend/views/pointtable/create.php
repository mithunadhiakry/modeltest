<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PointTable */

$this->title = 'Create Point Table';
$this->params['breadcrumbs'][] = ['label' => 'Point Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="point-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
