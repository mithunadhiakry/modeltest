<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Tempquestionlist */

$this->title = 'Create Tempquestionlist';
$this->params['breadcrumbs'][] = ['label' => 'Tempquestionlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempquestionlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
