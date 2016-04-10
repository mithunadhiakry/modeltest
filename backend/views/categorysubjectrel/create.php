<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Categorysubjectrel */

$this->title = 'Create Categorysubjectrel';
$this->params['breadcrumbs'][] = ['label' => 'Categorysubjectrels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorysubjectrel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
