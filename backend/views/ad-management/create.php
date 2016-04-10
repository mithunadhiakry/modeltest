<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdManagement */

$this->title = 'Create Ad Management';
$this->params['breadcrumbs'][] = ['label' => 'Ad Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-management-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
