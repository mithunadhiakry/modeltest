<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Contactform */

$this->title = 'Create Contactform';
$this->params['breadcrumbs'][] = ['label' => 'Contactforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contactform-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
