<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Countrycategoryrel */

$this->title = 'Create Countrycategoryrel';
$this->params['breadcrumbs'][] = ['label' => 'Countrycategoryrels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="countrycategoryrel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
