<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Chapter */

$this->title = 'Create Chapter';
$this->params['breadcrumbs'][] = ['label' => 'Chapters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chapter-create">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
