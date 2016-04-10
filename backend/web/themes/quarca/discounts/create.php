<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Discounts */

$this->title = 'Create Discounts';
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discounts-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
