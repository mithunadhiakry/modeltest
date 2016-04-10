<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Package */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'package_type')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'price_bd')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'duration')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'save_exam')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'advanced_reporting')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'share_exam')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
