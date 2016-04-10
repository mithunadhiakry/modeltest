<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Classlist */

$this->title = 'Create Classlist';
$this->params['breadcrumbs'][] = ['label' => 'Classlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classlist-create">

   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
