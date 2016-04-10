<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\QuestionsetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questionset-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'question_set_id') ?>

    <?= $form->field($model, 'question_set_name') ?>

    <?= $form->field($model, 'exam_time') ?>

    <?= $form->field($model, 'point_to_be_deducted') ?>

    <?php // echo $form->field($model, 'bonus_point') ?>

    <?php // echo $form->field($model, 'pasue') ?>

    <?php // echo $form->field($model, 'deduct_on_pause') ?>

    <?php // echo $form->field($model, 'country_id') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'sub_category_id') ?>

    <?php // echo $form->field($model, 'subject_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
