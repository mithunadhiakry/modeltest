<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\AdPosition */

$this->title = 'Create Ad Position';
$this->params['breadcrumbs'][] = ['label' => 'Ad Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-position-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
