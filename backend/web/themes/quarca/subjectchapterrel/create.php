<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Subjectchapterrel */

$this->title = 'Create Subjectchapterrel';
$this->params['breadcrumbs'][] = ['label' => 'Subjectchapterrels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjectchapterrel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
