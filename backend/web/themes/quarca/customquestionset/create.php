<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Questionset */

$this->title = 'Create Questionset';
$this->params['breadcrumbs'][] = ['label' => 'Questionsets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionset-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
