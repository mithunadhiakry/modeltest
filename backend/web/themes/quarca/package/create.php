<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Package */

$this->title = 'Create Package';
$this->params['breadcrumbs'][] = ['label' => 'Packages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
