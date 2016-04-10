<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PackageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'package_type') ?>

    <?= $form->field($model, 'price_bd') ?>

    <?= $form->field($model, 'duration') ?>

    <?= $form->field($model, 'share_exam') ?>

    <?php // echo $form->field($model, 'assign_exam_ability') ?>

    <?php // echo $form->field($model, 'save_exam') ?>

    <?php // echo $form->field($model, 'advanced_reporting') ?>

    <?php // echo $form->field($model, 'share_an_advance_report') ?>

    <?php // echo $form->field($model, 'time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
